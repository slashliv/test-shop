<?php

namespace App\DTO;

use App\Payment\PaymentInterface;
use JMS\Serializer\Annotation as JMS;

class PaymentDTO implements PaymentInterface
{
    /**
     * @JMS\SerializedName("sum")
     * @JMS\Type("float")
     *
     * @var float
     */
    private $sum;

    /**
     * @return float
     */
    public function getSum(): float
    {
        return $this->sum;
    }

    /**
     * @param float $sum
     *
     * @return PaymentDTO
     */
    public function setSum(float $sum): PaymentDTO
    {
        $this->sum = $sum;

        return $this;
    }
}