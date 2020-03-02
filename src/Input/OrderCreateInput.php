<?php

namespace App\Input;

use App\DTO\OrderDTO;
use JMS\Serializer\Annotation as JMS;

class OrderCreateInput
{
    /**
     * @var OrderDTO
     *
     * @JMS\Type("App\DTO\OrderDTO")
     */
    private $order;

    /**
     * @return OrderDTO
     */
    public function getOrder(): OrderDTO
    {
        return $this->order;
    }

    /**
     * @param OrderDTO $order
     *
     * @return OrderCreateInput
     */
    public function setOrder(OrderDTO $order): OrderCreateInput
    {
        $this->order = $order;

        return $this;
    }
}