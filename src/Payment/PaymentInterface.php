<?php

namespace App\Payment;

interface PaymentInterface
{
    /**
     * @return float
     */
    public function getSum(): float;
}
