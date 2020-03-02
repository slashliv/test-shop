<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\ORM\EntityRepository;

class OrderRepository extends EntityRepository
{
    /**
     * @param int $id
     *
     * @return Order|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getFull(int $id): ?Order
    {
        $queryBuilder = $this->createQueryBuilder('o')
            ->join('o.products', 'op')
            ->join('o.status', 'os')
            ->addSelect('op')
            ->addSelect('os')
            ->where('o.id = :id')
            ->setParameter('id', $id)
        ;

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}
