<?php

namespace App\DTO;

use JMS\Serializer\Annotation as JMS;

class OrderProductDTO
{
    /**
     * @var int
     *
     * @JMS\SerializedName("id")
     * @JMS\Type("integer")
     */
    private $id;

    /**
     * @var int
     *
     * @JMS\SerializedName("quantity")
     * @JMS\Type("integer")
     */
    private $quantity = 1;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return OrderProductDTO
     */
    public function setId(int $id): OrderProductDTO
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     *
     * @return OrderProductDTO
     */
    public function setQuantity(int $quantity): OrderProductDTO
    {
        $this->quantity = $quantity;

        return $this;
    }
}
