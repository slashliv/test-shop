<?php

namespace App\Output;

use App\Entity\Order;
use JMS\Serializer\Annotation as JMS;

class OrderOutput
{
    /**
     * @var bool
     *
     * @JMS\SerializedName("success")
     * @JMS\Type("boolean")
     * @JMS\Groups({
     *     "orderCreate",
     *     "pay"
     * })
     */
    private $success;

    /**
     * @var Order
     *
     * @JMS\SerializedName("order")
     * @JMS\Type("App\Entity\Order")
     * @JMS\Groups({
     *     "orderCreate",
     *     "pay"
     * })
     */
    private $order;

    /**
     * @param bool $success
     * @param Order $order
     */
    public function __construct($success = true, ?Order $order = null)
    {
        $this->success = $success;
        $this->order = $order;
    }
}
