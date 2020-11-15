<?php

namespace Drupal\commerce_momo\Plugin\Commerce\PaymentGateway;

use Drupal\commerce_momo\MoMo\TransactionResponse\ResponseBase;
use Drupal\commerce_order\Entity\OrderInterface;
use Drupal\commerce_payment\Exception\PaymentGatewayException;
use Drupal\commerce_payment\PaymentMethodTypeManager;
use Drupal\commerce_payment\PaymentTypeManager;
use Drupal\commerce_payment\Plugin\Commerce\PaymentGateway\OffsitePaymentGatewayBase;
use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\commerce_momo\MoMo\AllInOnePayGate;

/**
 * Provides All In One Pay Gate  for MoMo.
 *
 * @CommercePaymentGateway(
 *    id = "momo_allinone_paygate",
 *    label = @Translation("MoMo (All in One)"),
 *    display_label = @Translation("MoMo (All in One)"),
 *    forms = {
 *      "offsite-payment" =
 *   "Drupal\commerce_momo\PluginForm\AllInOnePayGateForm",
 *    },
 *    payment_type = "momo_payment",
 * )
 */
class AllInOnePayment extends OffsitePaymentGatewayBase {

  /**
   * Drupal\commerce_momo\MoMo\AllInOnePayGate.
   *
   * @var \Drupal\commerce_momo\MoMo\AllInOnePayGate
   */
  protected $allInOnePayGate;

  /**
   * Drupal\Core\Logger\LoggerChannel.
   *
   * @var \Drupal\Core\Logger\LoggerChannel
   */
  protected $logger;

  protected $messenger;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration,
                              $plugin_id,
                              $plugin_definition,
                              EntityTypeManagerInterface $entity_type_manager,
                              PaymentTypeManager $payment_type_manager,
                              PaymentMethodTypeManager $payment_method_type_manager,
                              TimeInterface $time,
                              AllInOnePayGate $aio_pay_gate,
                              LoggerChannelInterface $logger,
                              MessengerInterface $messenger) {
    parent::__construct(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $entity_type_manager,
      $payment_type_manager,
      $payment_method_type_manager,
      $time
    );

    $this->allInOnePayGate = $aio_pay_gate;
    $this->logger = $logger;
    $this->messenger = $messenger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('plugin.manager.commerce_payment_type'),
      $container->get('plugin.manager.commerce_payment_method_type'),
      $container->get('datetime.time'),
      $container->get('commerce_momo.momo_aio'),
      $container->get('logger.channel.commerce_momo'),
      $container->get('messenger')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    $configuration = [
      'api_endpoint' => '',
      'partner_code' => '',
      'access_key' => '',
      'secret_key' => '',
      'redirect_method' => 'get',
    ];
    return $configuration + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);
    $form['partner_code'] = [
      '#type' => 'textfield',
      '#required' => TRUE,
      '#title' => $this->t('Partner code'),
      '#default_value' => $this->configuration['partner_code'] ? $this->configuration['partner_code'] : '',
    ];
    $form['access_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Access Key'),
      '#default_value' => $this->configuration['access_key'] ? $this->configuration['access_key'] : '',
      '#required' => TRUE,
    ];
    $form['secret_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Secret Key'),
      '#default_value' => $this->configuration['secret_key'] ? $this->configuration['secret_key'] : '',
      '#required' => TRUE,
    ];
    $form['api_endpoint'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API Endpoint'),
      '#default_value' => $this->configuration['api_endpoint'] ? $this->configuration['api_endpoint'] : '',
      '#required' => TRUE,
      '#description' => t('Change to Dev (Test) / Production (Live) API Endpoint as per mode selected above.'),
    ];
    $form['redirect_method'] = [
      '#type' => 'radios',
      '#title' => $this->t('Redirect method'),
      '#options' => [
        'get' => $this->t('Redirect via GET (automatic)'),
        'get_manual' => $this->t('Redirect via GET (manual)'),
      ],
      '#default_value' => $this->configuration['redirect_method'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    parent::submitConfigurationForm($form, $form_state);
    if (!$form_state->getErrors()) {
      $values = $form_state->getValue($form['#parents']);
      $this->configuration['api_endpoint'] = $values['api_endpoint'];
      $this->configuration['partner_code'] = $values['partner_code'];
      $this->configuration['access_key'] = $values['access_key'];
      $this->configuration['secret_key'] = $values['secret_key'];
      $this->configuration['redirect_method'] = $values['redirect_method'];
    }
  }

  /**
   * {@inheritdoc}
   */
  public function onReturn(OrderInterface $order, Request $request) {
    $response = $this->allInOnePayGate->getTransactionResponse($request->query->all());
    if (ResponseBase::SUCCESS != $response->getCode()) {
      $this->messenger->addError($response->getMessage());
      throw new PaymentGatewayException($response->getMessage());
    }
    $payment_id = $response->paymentId;
    try {
      /** @var \Drupal\commerce_payment\Entity\PaymentInterface $payment */
      $payment = $this->entityTypeManager->getStorage('commerce_payment')
        ->load($payment_id);
      $this->allInOnePayGate->setPaymentGateWay($payment);
    }
    catch (\Exception $ex) {
      $this->messenger->addError($this->t('Payment entity not found.'));
      throw new PaymentGatewayException($ex->getMessage());
    }
    if (!$this->allInOnePayGate->verifySignature($request->query->all())) {
      $this->messenger->addError($this->t('Invalid signature.'));
      throw new PaymentGatewayException('Invalid signature.');
    }

    $payment->set('remote_id', $response->transId);
    $payment->set('remote_state', $response->getMessage());
    $payment->set('state', 'authorization');
    $payment->set('authorized', $this->time->getRequestTime());
    try {
      $payment->save();
      $this->logger->log('notice', 'Payment entity with id ' . $payment->id() . ' has been updated.');
    }
    catch (\Exception $ex) {
      $this->messenger->addError($this->t('Cannot update process payment.'));
      throw new PaymentGatewayException($this->t('Cannot update process payment.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function onCancel(OrderInterface $order, Request $request) {
    $this->messenger
      ->addError($this->t('You have canceled checkout at @gateway but may resume the checkout process here when you are ready.', [
        '@gateway' => $this->getDisplayLabel(),
      ]), 'error');
  }

  /**
   * {@inheritdoc}
   */
  public function onNotify(Request $request) {
    $response = $this->allInOnePayGate->getTransactionResponse($request->request->all());

    if (ResponseBase::SUCCESS != $response->getCode()) {
      $this->messenger->addError($response->getMessage());
      throw new PaymentGatewayException($response->getMessage());
    }
    $payment_id = $response->paymentId;
    try {
      $payment_storage = $this->entityTypeManager->getStorage('commerce_payment');
      /** @var \Drupal\commerce_payment\Entity\PaymentInterface $payment */
      $payment = $payment_storage->load($payment_id);
      $this->allInOnePayGate->setPaymentGateWay($payment);
    }
    catch (\Exception $ex) {
      $this->messenger->addError($this->t('Payment entity not found.'));
      throw new PaymentGatewayException($ex->getMessage());
    }

    if (!$this->allInOnePayGate->verifySignature($request->request->all())) {
      $this->messenger->addError($this->t('Invalid signature.'));
      throw new PaymentGatewayException('Invalid signature.');
    }

    $payment->set('remote_id', $response->transId);
    $payment->set('remote_state', $response->getMessage());
    $payment->setState('completed');

    try {
      $payment->save();
      $this->logger->log('notice', 'Notify: Payment entity with id ' . $payment->id() . ' has been updated.');
    }
    catch (\Exception $ex) {
      $this->messenger->addError($this->t('Cannot update process payment.'));
      throw new PaymentGatewayException($this->t('Cannot update process payment.'));
    }
    $response_data = $this->allInOnePayGate->generateNotifyResponse($request->request->all());
    // This notify URL can switch the commerce payment status.
    // But I cannot make the transaction in MoMo switch to complete
    // as their document said.
    /* @see https://developers.momo.vn/#/docs/aio/?id=http-response-ipn */
    // I will contact MoMo support to get more info.
    // Please post issue if you have solution.
    return new JsonResponse($response_data, 200, [
      'Content-Type' => 'application/json',
      'charset' => 'UTF-8',
    ]);
  }

}
