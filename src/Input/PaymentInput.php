<?php

namespace App\Input;

use App\DTO\PaymentDTO;
use JMS\Serializer\Annotation as JMS;

class PaymentInput
{
    /**
     * @var PaymentDTO
     *
     * @JMS\SerializedName("payment")
     * @JMS\Type("App\DTO\PaymentDTO")
     */
    public $payment;

    /**
     * @return PaymentDTO
     */
    public function getPayment(): PaymentDTO
    {
        return $this->payment;
    }

    /**
     * @param PaymentDTO $payment
     *
     * @return PaymentInput
     */
    public function setPayment(PaymentDTO $payment): PaymentInput
    {
        $this->payment = $payment;

        return $this;
    }
}
