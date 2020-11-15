<?php

namespace Drupal\commerce_momo\MoMo;

use Drupal\commerce_momo\MoMo\TransactionResponse\ApiResponse;
use Drupal\commerce_momo\MoMo\TransactionResponse\PaymentResponse;
use Drupal\commerce_payment\Entity\PaymentInterface;
use Drupal\commerce_payment\Exception\PaymentGatewayException;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Config\ConfigManagerInterface;
use Drupal\Core\Url;
use GuzzleHttp\ClientInterface;

/**
 * Class AllInOnePayGate.
 */
class AllInOnePayGate {

  /**
   * Configuration of payment gateway.
   *
   * @var array
   */
  protected $configuration;

  /**
   * Drupal\commerce_payment\Entity\PaymentInterface.
   *
   * @var \Drupal\commerce_payment\Entity\PaymentInterface
   */
  protected $payment;

  /**
   * Drupal\commerce_order\Entity\OrderInterface.
   *
   * @var \Drupal\commerce_order\Entity\OrderInterface
   */
  protected $order;

  /**
   * Drupal\commerce_payment\Plugin\Commerce\PaymentGateway\PaymentGatewayInterface.
   *
   * @var \Drupal\commerce_payment\Plugin\Commerce\PaymentGateway\PaymentGatewayInterface
   */
  protected $paymentGateWayPlugin;

  /**
   * Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Drupal\Core\Config\ConfigManagerInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigManagerInterface
   */
  protected $configManager;

  /**
   * GuzzleHttp\ClientInterface definition.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;

  /**
   * Constructs a new AllInOneService object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   Drupal\Core\Entity\EntityTypeManagerInterface.
   * @param \Drupal\Core\Config\ConfigManagerInterface $config_manager
   *   Drupal\Core\Config\ConfigManagerInterface.
   * @param \GuzzleHttp\ClientInterface $http_client
   *   GuzzleHttp\ClientInterface.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, ConfigManagerInterface $config_manager, ClientInterface $http_client) {
    $this->entityTypeManager = $entity_type_manager;
    $this->configManager = $config_manager;
    $this->httpClient = $http_client;
  }

  /**
   * Set payment entity, payment gateway plugin, configuration.
   *
   * @param \Drupal\commerce_payment\Entity\PaymentInterface $payment
   *   Payment entity.
   */
  public function setPaymentGateWay(PaymentInterface $payment) {
    $this->payment = $payment;
    $this->paymentGateWayPlugin = $payment->getPaymentGateway()->getPlugin();
    $this->configuration = $this->paymentGateWayPlugin->getConfiguration();
    $this->order = $payment->getOrder();
  }

  /**
   * Capture MoMo Wallet to get redirect URL.
   *
   * @return \Drupal\commerce_momo\MoMo\TransactionResponse\ApiResponse
   *   Response data from API, map the data to ApiResponse class.
   *
   * @throws \Exception
   */
  public function captureMoMoWallet() {
    // MoMo API require unique order id every call.
    // Generate id with this format: [payment id]_[order id]_[date('ymdHis')].
    // After return from MoMo we need extract the Id with this format.
    // Please post issue if you have better solution.
    $generate_id = $this->payment->id() . '_' . $this->order->id() . '_' . date('ymdHis');
    $attributes = [
      Attribute::PARTNER_CODE => $this->configuration['partner_code'],
      Attribute::ACCESS_KEY => $this->configuration['access_key'],
      Attribute::REQUEST_ID => $generate_id,
      Attribute::AMOUNT => $this->payment->getAmount()->getNumber(),
      Attribute::ORDER_ID => $generate_id,
      Attribute::ORDER_INFO => $this->getOrderInfo(),
      Attribute::RETURN_URL => $this->getReturnUrl(),
      Attribute::NOTIFY_URL => $this->getNotifyUrl(),
      Attribute::EXTRA_DATA => $this->getExtraData(),
    ];
    $string_to_hash = $this->generateStringToHash($attributes);

    $attributes[Attribute::SIGNATURE] = $this->hashString($string_to_hash, $this->configuration['secret_key']);
    $attributes[Attribute::REQUEST_TYPE] = 'captureMoMoWallet';

    try {
      $response = $this->httpClient->post($this->configuration['api_endpoint'], ['json' => $attributes])
        ->getBody()
        ->getContents();
    }
    catch (\Exception $ex) {
      throw $ex;
    }
    if (empty($response)) {
      throw new PaymentGatewayException('Cannot get pay url from MoMo API.');
    }
    return new ApiResponse(Json::decode($response));
  }

  /**
   * Generate string from data array to hash.
   *
   * @param array $data
   *   Data to generate.
   *
   * @return string
   *   String to hash.
   */
  public function generateStringToHash(array $data) {
    $string_to_hash = '';
    foreach ($data as $key => $value) {
      $string_to_hash .= (!empty($string_to_hash) ? '&' : '') . $key . '=' . $value;
    }
    return $string_to_hash;
  }

  /**
   * Return order info by concat order item's title.
   *
   * @return string
   *   String.
   */
  public function getOrderInfo() {
    $order_info = [];
    foreach ($this->order->getItems() as $order_item) {
      $order_info[] = $order_item->getTitle();
    }
    return implode('; ', $order_info);
  }

  /**
   * Get Url to redirect after payment.
   *
   * @return \Drupal\Core\GeneratedUrl|string
   *   Return url.
   */
  public function getReturnUrl() {
    return Url::FromRoute('commerce_payment.checkout.return', [
      'commerce_order' => $this->order->id(),
      'step' => 'payment',
    ], ['absolute' => TRUE])->toString();
  }

  /**
   * Extra data get by order object.
   *
   * @return string
   *   Extra data.
   */
  public function getExtraData() {
    $extra_data['email'] = $this->order->getEmail();
    $extra_data['paymentId'] = $this->payment->id();
    $extra_data['orderId'] = $this->order->id();
    $address = $this->order->getBillingProfile()->address->first();
    if ($address) {
      $extra_data['street'] = $address->getAddressLine1();
      $extra_data['city'] = $address->getLocality();
      $extra_data['state_province'] = $address->getAdministrativeArea();
      $extra_data['postal_code'] = $address->getPostalCode();
      $extra_data['country'] = $address->getCountryCode();
    }
    $extra_data_string = '';
    foreach ($extra_data as $key => $value) {
      if ($value) {
        $extra_data_string .= (!empty($extra_data_string) ? ';' : '') . $key . '=' . $value;
      }
    }
    return $extra_data_string;
  }

  /**
   * Hash hmac sha256 with secret_key.
   *
   * @param string $string_to_hash
   *   String to hash.
   * @param string $secret_key
   *   Secret key.
   *
   * @return string
   *   Hash string.
   */
  public static function hashString($string_to_hash, $secret_key) {
    return hash_hmac("sha256", $string_to_hash, $secret_key);
  }

  /**
   * Get notify url of payment gateway plugin.
   *
   * @return \Drupal\Core\GeneratedUrl|string
   *   Notify url.
   */
  private function getNotifyUrl() {
    return Url::FromRoute('commerce_payment.notify', [
      'commerce_payment_gateway' => $this->payment->getPaymentGateway()->id(),
    ], ['absolute' => TRUE, 'https' => TRUE])->toString();
  }

  /**
   * Get Payment Plugin configuration.
   *
   * @return array
   *   Configuration.
   */
  public function getConfiguration() {
    return $this->configuration;
  }

  /**
   * Get transaction response.
   *
   * @param array $data
   *   Data return from MoMo.
   *
   * @return \Drupal\commerce_momo\MoMo\TransactionResponse\PaymentResponse
   *   Response Object.
   */
  public function getTransactionResponse(array $data) {
    return new PaymentResponse($data);
  }

  /**
   * Verify signature in response data.
   *
   * @param array $data
   *   Data return from MoMo.
   *
   * @return bool
   *   Return TRUE if valid signature.
   */
  public function verifySignature(array $data) {
    $attributes = [
      Attribute::PARTNER_CODE => $data[Attribute::PARTNER_CODE],
      Attribute::ACCESS_KEY => $data[Attribute::ACCESS_KEY],
      Attribute::REQUEST_ID => $data[Attribute::REQUEST_ID],
      Attribute::AMOUNT => $data[Attribute::AMOUNT],
      Attribute::ORDER_ID => $data[Attribute::ORDER_ID],
      Attribute::ORDER_INFO => $data[Attribute::ORDER_INFO],
      Attribute::ORDER_TYPE => $data[Attribute::ORDER_TYPE],
      Attribute::TRANS_ID => $data[Attribute::TRANS_ID],
      Attribute::MESSAGE => $data[Attribute::MESSAGE],
      Attribute::LOCAL_MESSAGE => $data[Attribute::LOCAL_MESSAGE],
      Attribute::RESPONSE_TIME => $data[Attribute::RESPONSE_TIME],
      Attribute::ERROR_CODE => $data[Attribute::ERROR_CODE],
      Attribute::PAY_TYPE => $data[Attribute::PAY_TYPE],
      Attribute::EXTRA_DATA => $data[Attribute::EXTRA_DATA],
    ];
    $signature = $data['signature'];
    $string_to_hash = $this->generateStringToHash($attributes);
    $hash = $this->hashString($string_to_hash, $this->configuration['secret_key']);
    return ($signature === $hash);
  }

  /**
   * Generate response json for notify URL.
   *
   * @param array $data
   *   Array data send by MoMo.
   *
   * @return array
   *   Array data return for MoMo.
   */
  public function generateNotifyResponse(array $data) {
    $generate_id = $this->payment->id() . '_' . $this->order->id() . '_' . date('ymdHis');
    $data_response = [
      Attribute::PARTNER_CODE => $this->configuration['partner_code'],
      Attribute::ACCESS_KEY => $this->configuration['access_key'],
      Attribute::REQUEST_ID => $generate_id,
      Attribute::ORDER_ID => $data[Attribute::ORDER_ID],
      Attribute::ERROR_CODE => $data[Attribute::ERROR_CODE],
      Attribute::MESSAGE => $data[Attribute::MESSAGE],
      Attribute::RESPONSE_TIME => date('Y-m-d H:i:s'),
      Attribute::EXTRA_DATA => $this->getExtraData(),
    ];
    $string_to_hash = $this->generateStringToHash($data_response);
    $data_response[Attribute::SIGNATURE] = $this->hashString($string_to_hash, $this->configuration['secret_key']);
    return $data_response;
  }

}
