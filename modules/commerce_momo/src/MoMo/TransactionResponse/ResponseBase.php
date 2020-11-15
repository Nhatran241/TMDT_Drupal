<?php

namespace Drupal\commerce_momo\MoMo\TransactionResponse;

/**
 * Class ResponseBase.
 *
 * @package Drupal\commerce_momo\MoMo\TransactionResponse
 */
abstract class ResponseBase {

  const SUCCESS = 0;

  const INIT_TRANSACTION = -1;

  const MISSING_MERCHANT_INFO = 1;

  const INVALID_ORDER_ID = 2;

  const INVALID_AMOUNT = 4;

  const INVALID_SIGNATURE = 5;

  const ORDER_ID_EXIST = 6;

  const TRANSACTION_WAITING_FOR_PROCESS = 7;

  const REQUEST_EXIST = 12;

  const MERCHANT_NOT_ACTIVE = 14;

  const SYSTEM_MAINTENANCE = 29;

  const TRANSACTION_PAID = 32;

  const TRANSACTION_CANNOT_REFUND = 34;

  const TRANSACTION_REFUND_PROCESSED = 34;

  const TRANSACTION_EXPIRED = 36;

  const ACCOUNT_TRANSACTION_LIMIT = 37;

  const ACCOUNT_EXIST_AMOUNT = 38;

  const INVALID_REQUEST_FORMAT = 42;

  const NOT_SUPPORT_REQUEST = 44;

  const TRANSACTION_CANCELED = 49;

  const TRANSACTION_NOT_EXIST = 58;

  const INVALID_REQUEST = 59;

  const BANK_PAYMENT_FAIL = 63;

  const MISSING_REQUEST_TYPE = 76;

  const VERIFY_CUSTOMER_FAIL = 80;

  const UNKNOWN_ERROR = 99;

  const NOT_CONNECT_BANK_ACCOUNT = 9043;

  /**
   * Response code from MoMo.
   *
   * @var int
   */
  protected $code;

  /**
   * Message from MoMo.
   *
   * @var string
   */
  protected $message;

  protected $response;

  /**
   * ResponseBase constructor.
   *
   * @param array $response
   *   Response data from MoMo Api.
   */
  public function __construct(array $response) {
    $this->code = $response['errorCode'];
    $this->message = $response['message'];
    $this->response = $response;
  }

  /**
   * Get code.
   *
   * @return int
   *   Return code.
   */
  public function getCode() {
    return $this->code;
  }

  /**
   * Get message.
   *
   * @return string
   *   Return message.
   */
  public function getMessage() {
    return $this->message;
  }

}
