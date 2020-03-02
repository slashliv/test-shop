<?php

namespace App\Payment;

use App\Entity\Order;
use App\Entity\OrderStatus;
use Doctrine\ORM\EntityManagerInterface;

class OrderChangePaymentHandler implements PaymentHandlerInterface
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
     * @inheritDoc
     */
    public function handle(Order $order, PaymentInterface $payment): array
    {
        $order->setStatus($this->getStatus());

        return [];
    }

    /**
     * @return OrderStatus
     */
    private function getStatus(): OrderStatus
    {
        return $this->entityManager->getRepository(OrderStatus::class)->findOneBy([
            'code' => OrderStatus::CODE_PAID,
        ]);
    }
}
