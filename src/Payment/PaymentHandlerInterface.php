<?php

namespace App\Payment;

use App\Entity\Order;

interface PaymentHandlerInterface
{
    /**
     * @param Order $order
     * @param PaymentInterface $payment
     *
     * @return array
     */
    public function handle(Order $order, PaymentInterface $payment): array;
}
