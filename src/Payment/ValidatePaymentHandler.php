<?php

namespace App\Payment;

use App\Entity\Order;
use App\Entity\OrderStatus;

class ValidatePaymentHandler implements PaymentHandlerInterface
{
    const ERROR_STATUS = 'Order already paid.';
    const ERROR_PAYMENT_SUM = 'Payment sum should be equal to order total sum.';

    /**
     * @param Order $order
     * @param PaymentInterface $payment
     *
     * @return array
     */
    public function handle(Order $order, PaymentInterface $payment): array
    {
        if (OrderStatus::CODE_PAID === $order->getStatus()->getCode()) {
            return [self::ERROR_STATUS];
        }

        if (0 !== bccomp($payment->getSum(), $order->getTotalSum())) {
            return [self::ERROR_PAYMENT_SUM];
        }

        return [];
    }
}
