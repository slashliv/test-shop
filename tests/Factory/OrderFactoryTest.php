<?php

namespace App\Tests\Factory;

use App\DTO\OrderDTO;
use App\DTO\OrderProductDTO;
use App\Entity\OrderStatus;
use App\Entity\Product;
use App\Factory\OrderFactory;
use App\Tests\Factory\Traits\OrderProductFactoryTrait;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\TestCase;

class OrderFactoryTest extends TestCase
{
    use OrderProductFactoryTrait;

    public function testCreate()
    {
        $product = new Product();
        $product
            ->setPrice(100)
            ->setName('Product1')
        ;

        $orderFactory = $this->getOrderFactory($product);

        $orderProductDTO = new OrderProductDTO();
        $orderProductDTO
            ->setId(1)
            ->setQuantity(2)
        ;

        $orderData = new OrderDTO();
        $orderData->setProducts([$orderProductDTO]);

        $order = $orderFactory->create($orderData);

        $this->assertEquals(200, $order->getTotalSum());
        $this->assertEquals(100, $order->getProducts()[0]->getPrice());
        $this->assertEquals(2, $order->getProducts()[0]->getQuantity());
        $this->assertEquals($product, $order->getProducts()[0]->getProduct());
    }

    /**
     * @param Product|null $product
     *
     * @return OrderFactory
     */
    private function getOrderFactory(Product $product = null): OrderFactory
    {
        $orderProductFactory= $this->getOrderProductFactory($product);

        $orderStatus = new OrderStatus();
        $orderStatus
            ->setName(OrderStatus::CODE_NEW)
            ->setCode(OrderStatus::CODE_NEW)
        ;

        $orderStatusRepository = $this->createMock(EntityRepository::class);
        $orderStatusRepository->method('findOneBy')->willReturn($orderStatus);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->method('getRepository')->willReturn($orderStatusRepository);

        $orderFactory = new OrderFactory($entityManager, $orderProductFactory);

        return $orderFactory;
    }
}