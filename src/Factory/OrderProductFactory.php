<?php

namespace App\Factory;

use App\DTO\OrderProductDTO;
use App\Entity\OrderProduct;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

class OrderProductFactory implements OrderProductFactoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param $orderProductData
     *
     * @return OrderProduct
     *
     * @throws EntityNotFoundException
     */
    public function create($orderProductData): OrderProduct
    {
        return $this->doCreate($orderProductData);
    }

    /**
     * @param OrderProductDTO $orderProductData
     *
     * @return OrderProduct
     *
     * @throws EntityNotFoundException
     */
    private function doCreate(OrderProductDTO $orderProductData): OrderProduct
    {
        $productRepository = $this->entityManager->getRepository(Product::class);
        $product = $productRepository->find($orderProductData->getId());
        if (null === $product) {
            throw new EntityNotFoundException(sprintf(
                'Entity %s with id=%d not found',
                Product::class,
                $orderProductData->getId()
            ));
        }

        $orderProduct = new OrderProduct();
        $orderProduct
            ->setProduct($product)
            ->setQuantity($orderProductData->getQuantity())
            ->setPrice($product->getPrice())
        ;

        return $orderProduct;
    }
}
