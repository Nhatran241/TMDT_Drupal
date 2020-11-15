<?php

namespace Drupal\commerce_momo\Plugin\Commerce\PaymentType;

use Drupal\commerce_payment\Plugin\Commerce\PaymentType\PaymentTypeBase;

/**
 * Provides the MoMo payment type.
 *
 * @CommercePaymentType(
 *   id = "momo_payment",
 *   label = @Translation("MoMo"),
 * )
 */
class MomoPayment extends PaymentTypeBase {

  /**
   * {@inheritdoc}
   */
  public function buildFieldDefinitions() {
    return [];
  }

}
