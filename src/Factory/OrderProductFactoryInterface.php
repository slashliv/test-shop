<?php

namespace App\Factory;

use App\Entity\OrderProduct;

interface OrderProductFactoryInterface
{
    /**
     * @param $orderProductData
     *
     * @return OrderProduct
     */
    public function create($orderProductData): OrderProduct;
}
