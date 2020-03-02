<?php

namespace App\DataFixtures\Initial;

use App\Entity\Product;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class ProductData extends AbstractFixture
{
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $products = [];

        $price = 100.0;
        for ($i = 0; $i < 20; $i++) {
            $product = new Product();

            $multiplier = $i + 1;
            $product
                ->setName('Product' . $i)
                ->setPrice($price * $multiplier)
            ;

            $products[] = $product;
        }

        foreach ($products as $product) {
            $manager->persist($product);
        }
        $manager->flush();
    }
}
