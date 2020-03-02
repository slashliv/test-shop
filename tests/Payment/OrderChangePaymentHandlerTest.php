<?php

namespace App\Tests\Payment;

use App\Entity\OrderStatus;
use App\Payment\OrderChangePaymentHandler;
use App\Payment\PaymentHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class OrderChangePaymentHandlerTest extends AbstractPaymentHandlerTest
{
    /**
     * @dataProvider dataProvider
     */
    public function testHandle($orderData, $paymentData, $expectedResult)
    {
        $payment = $this->createPayment(...$paymentData);
        $order = $this->createOrder(...$orderData);

        $handler = $this->createHandler();
        $result = $handler->handle($order, $payment);
        $this->assertEquals($expectedResult, $result);
        $this->assertEquals(OrderStatus::CODE_PAID, $order->getStatus()->getCode());
    }

    public function dataProvider()
    {
        return [
            [
                'order' => [100, OrderStatus::CODE_NEW],
                'payment' => [100],
                'result' => [],
            ],
        ];
    }

    /**
     * @param array $data
     *
     * @return PaymentHandlerInterface
     */
    protected function createHandler(array $data = []): PaymentHandlerInterface
    {
        $orderStatus = $this->createOrderStatus(OrderStatus::CODE_PAID);

        $orderStatusRepository = $this->createMock(EntityRepository::class);
        $orderStatusRepository->method('findOneBy')->willReturn($orderStatus);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->method('getRepository')->willReturn($orderStatusRepository);

        return new OrderChangePaymentHandler($entityManager);
    }
}
