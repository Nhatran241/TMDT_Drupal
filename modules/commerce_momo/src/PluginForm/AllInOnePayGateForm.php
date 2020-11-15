<?php

namespace Drupal\commerce_momo\PluginForm;

use Drupal\commerce\Response\NeedsRedirectException;
use Drupal\commerce_momo\MoMo\AllInOnePayGate;
use Drupal\commerce_momo\MoMo\TransactionResponse\ResponseBase;
use Drupal\commerce_payment\PluginForm\PaymentOffsiteForm;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provide payment form for MoMo All In One.
 *
 * @package Drupal\commerce_momo\PluginForm
 */
class AllInOnePayGateForm extends PaymentOffsiteForm implements ContainerInjectionInterface {

  /**
   * Drupal\commerce_momo\MoMo\AllInOnePayGate.
   *
   * @var \Drupal\commerce_momo\MoMo\AllInOnePayGate
   */
  public $allInOnePayGate;

  /**
   * Drupal\Core\Logger\LoggerChannel.
   *
   * @var \Drupal\Core\Logger\LoggerChannel
   */
  public $logger;

  /**
   * Drupal\Core\Messenger\MessengerInterface.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  public $messenger;

  /**
   * AllInOnePayGateForm constructor.
   *
   * @param \Drupal\commerce_momo\MoMo\AllInOnePayGate $all_in_one_paygate
   *   AllInOnePayGate.
   * @param \Drupal\Core\Logger\LoggerChannelInterface $logger_channel
   *   LoggerChannelInterface.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   MessengerInterface.
   */
  public function __construct(AllInOnePayGate $all_in_one_paygate, LoggerChannelInterface $logger_channel, MessengerInterface $messenger) {
    $this->allInOnePayGate = $all_in_one_paygate;
    $this->logger = $logger_channel;
    $this->messenger = $messenger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('commerce_momo.momo_aio'), $container->get('logger.channel.commerce_momo'), $container->get('messenger'));
  }

  /**
   * {@inheritdoc}
   *
   * @throws \Exception
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);
    /** @var \Drupal\commerce_payment\Entity\PaymentInterface $payment */
    $payment = $this->entity;
    $error_redirect_url = Url::FromRoute('commerce_checkout.form', [
      'absolute' => TRUE,
      'step' => 'review',
      'commerce_order' => $payment->getOrderId(),
    ])->toString();
    try {
      $payment->save();
      $this->allInOnePayGate->setPaymentGateWay($payment);
      $response = $this->allInOnePayGate->captureMoMoWallet();
      $this->logger->log('notice', 'Payment entity with id ' . $payment->id() . ' has been added.');
    }
    catch (\Exception $ex) {
      $this->logger->error($ex->getMessage());
      $this->messenger->addError('An error occurred while processing your payment request.');
      throw new NeedsRedirectException($error_redirect_url);

    }

    if (ResponseBase::SUCCESS != $response->getCode()) {
      $this->logger->error('Cannot get pay url from MoMo server. Payment Id ' . $payment->id());
      $this->messenger->addError('An error occurred while processing your payment request.');
      throw new NeedsRedirectException($error_redirect_url);
    }

    $form = $this->buildRedirectForm($form, $form_state, $response->payUrl, [], 'get');
    return $form;
  }

}
