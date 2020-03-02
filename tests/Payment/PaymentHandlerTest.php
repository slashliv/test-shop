<?php

namespace App\Tests\Payment;

use App\Entity\OrderStatus;
use App\Payment\PaymentHandler;
use App\Payment\PaymentHandlerInterface;
use App\Payment\ValidatePaymentHandler;

class PaymentHandlerTest extends AbstractPaymentHandlerTest
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
    }

    public function dataProvider()
    {
        return [
            [
                'order' => [100, OrderStatus::CODE_NEW],
                'payment' => [100],
                'result' => [],
            ],
            [
                'order' => [200, OrderStatus::CODE_NEW],
                'payment' => [100],
                'result' => [ValidatePaymentHandler::ERROR_PAYMENT_SUM],
            ],
            [
                'order' => [100, OrderStatus::CODE_PAID],
                'payment' => [100],
                'result' => [ValidatePaymentHandler::ERROR_STATUS],
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
        $handler = new PaymentHandler();
        $validatorHandler = new ValidatePaymentHandler();

        $handler->addHandler($validatorHandler);

        return $handler;
    }
}