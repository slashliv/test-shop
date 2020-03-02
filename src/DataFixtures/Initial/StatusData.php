<?php

namespace App\DataFixtures\Initial;

use App\Entity\OrderStatus;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class StatusData extends AbstractFixture
{
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $new = new OrderStatus();
        $new
            ->setName('Новый')
            ->setCode(OrderStatus::CODE_NEW)
        ;

        $paid = new OrderStatus();
        $paid
            ->setName('Оплачен')
            ->setCode(OrderStatus::CODE_PAID)
        ;

        $manager->persist($new);
        $manager->persist($paid);

        $manager->flush();
    }
}