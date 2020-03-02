<?php

namespace App\Factory;

use App\DTO\OrderDTO;
use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\OrderStatus;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class OrderFactory implements OrderFactoryInterface
{
    const DEFAULT_STATUS_CODE = OrderStatus::CODE_NEW;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var OrderProductFactoryInterface
     */
    private $orderProductCreator;

    /**
     * @param EntityManagerInterface $entityManager
     * @param OrderProductFactoryInterface $orderProductCreator
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        OrderProductFactoryInterface $orderProductCreator
    ) {
        $this->entityManager = $entityManager;
        $this->orderProductCreator = $orderProductCreator;
    }

    /**
     * @inheritDoc
     */
    public function create($orderData): Order
    {
        return $this->doCreate($orderData);
    }

    /**
     * @param OrderDTO $orderData
     *
     * @return Order
     *
     * @throws \Doctrine\ORM\ORMException
     */
    private function doCreate(OrderDTO $orderData): Order
    {
        $this->loadProducts($orderData);

        $order = new Order();

        $order->setStatus($this->getStatus($orderData));
        foreach ($this->getOrderProducts($orderData) as $orderProduct) {
            $order->addProduct($orderProduct);
        }

        return $order;
    }


    /**
     * @param OrderDTO $orderData
     *
     * @return OrderStatus
     *
     * @throws \Doctrine\ORM\ORMException
     */
    private function getStatus(OrderDTO $orderData): OrderStatus
    {
        return $this->entityManager->getRepository(OrderStatus::class)->findOneBy([
            'code' => self::DEFAULT_STATUS_CODE,
        ]);
    }

    /**
     * @param OrderDTO $orderData
     *
     * @return OrderProduct[]
     */
    private function getOrderProducts(OrderDTO $orderData): array
    {
        /** @var OrderProduct[] $orderProducts */
        $orderProducts = [];
        $orderProductDataList = $orderData->getProducts();
        foreach ($orderProductDataList as $orderProductData) {
            $orderProducts[] = $this->orderProductCreator->create($orderProductData);
        }

        return $orderProducts;
    }

    /**
     * @param OrderDTO $orderData
     */
    private function loadProducts(OrderDTO $orderData)
    {
        $productIds = [];
        foreach ($orderData->getProducts() as $product) {
            $productIds[] = $product->getId();
        }

        $this->entityManager->getRepository(Product::class)->findBy([
            'id' => $productIds,
        ]);
    }
}
