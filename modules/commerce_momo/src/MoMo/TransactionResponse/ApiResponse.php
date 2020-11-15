<?php

namespace Drupal\commerce_momo\MoMo\TransactionResponse;

/**
 * Class ApiResponse.
 *
 * @package Drupal\commerce_momo\MoMo\TransactionResponse
 */
class ApiResponse extends ResponseBase {

  public $payUrl;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $response) {
    parent::__construct($response);
    $this->payUrl = $response['payUrl'];
  }

}
