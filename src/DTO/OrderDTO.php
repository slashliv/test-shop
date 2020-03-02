<?php

namespace App\DTO;

use JMS\Serializer\Annotation as JMS;

class OrderDTO
{
    /**
     * @var OrderProductDTO[]
     *
     * @JMS\SerializedName("products")
     * @JMS\Type("array<App\DTO\OrderProductDTO>")
     */
    private $products;

    /**
     * @return OrderProductDTO[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param OrderProductDTO[] $products
     *
     * @return OrderDTO
     */
    public function setProducts(array $products): OrderDTO
    {
        $this->products = $products;

        return $this;
    }
}