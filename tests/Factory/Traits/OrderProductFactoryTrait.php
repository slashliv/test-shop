<?php


namespace App\Tests\Factory\Traits;


use App\Entity\Product;
use App\Factory\OrderProductFactory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

trait OrderProductFactoryTrait
{
    /**
     * @param Product|null $product
     *
     * @return OrderProductFactory
     */
    private function getOrderProductFactory(Product $product = null): OrderProductFactory
    {
        if (null === $product) {
            $product = new Product();
            $product
                ->setName('Product1')
                ->setPrice(100)
            ;
        }

        $productRepository  = $this->createMock(EntityRepository::class);
        $productRepository->method('find')->willReturn($product);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->method('getRepository')->willReturn($productRepository);

        return new OrderProductFactory($entityManager);
    }
}
