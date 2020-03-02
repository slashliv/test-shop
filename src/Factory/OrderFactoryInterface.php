<?php

namespace App\Factory;

use App\Entity\Order;

interface OrderFactoryInterface
{
    /**
     * @param $orderData
     *
     * @return Order
     */
    public function create($orderData): Order;
}
