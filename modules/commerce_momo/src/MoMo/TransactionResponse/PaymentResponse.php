<?php

namespace Drupal\commerce_momo\MoMo\TransactionResponse;

/**
 * Class PaymentResponse.
 *
 * @package Drupal\commerce_momo\MoMo\TransactionResponse
 */
class PaymentResponse extends ResponseBase {

  public $paymentId;

  public $transId;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $response) {
    parent::__construct($response);
    $explode_id = explode('_', $response['orderId']);
    $this->paymentId = $explode_id[0];
    $this->transId = $response['transId'];
  }

}
