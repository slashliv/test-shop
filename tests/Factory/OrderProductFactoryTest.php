<?php

namespace App\Tests\Factory;

use App\DTO\OrderProductDTO;
use App\Entity\Product;
use App\Tests\Factory\Traits\OrderProductFactoryTrait;
use PHPUnit\Framework\TestCase;

class OrderProductFactoryTest extends TestCase
{
    use OrderProductFactoryTrait;

    public function testCreate()
    {
        $product = new Product();
        $product
            ->setPrice(100)
            ->setName('Product1')
        ;

        $orderProductFactory = $this->getOrderProductFactory($product);

        $orderProductDTO = new OrderProductDTO();
        $orderProductDTO
            ->setId(1)
            ->setQuantity(2)
        ;

        $orderProduct = $orderProductFactory->create($orderProductDTO);

        $this->assertEquals(100, $orderProduct->getPrice());
        $this->assertEquals(2, $orderProduct->getQuantity());
        $this->assertEquals($product, $orderProduct->getProduct());
    }
}
