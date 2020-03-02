<?php

namespace App\Tests\Payment;

use App\Entity\OrderStatus;
use App\Payment\HttpCallPaymentHandler;
use App\Payment\PaymentHandlerInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;

class HttpCallPaymentHandlerTest extends AbstractPaymentHandlerTest
{
    /**
     * @dataProvider dataProvider
     */
    public function testHandle($orderData, $paymentData, $clientData, $expectedResult)
    {
        $payment = $this->createPayment(...$paymentData);
        $order = $this->createOrder(...$orderData);

        $handler = $this->createHandler(['client' => $clientData]);
        $result = $handler->handle($order, $payment);
        $this->assertEquals($expectedResult, $result);
    }

    public function dataProvider()
    {
        return [
            [
                'order' => [100, OrderStatus::CODE_NEW],
                'payment' => [100],
                'client' => [
                    'status' => 200,
                ],
                'result' => [],
            ],
            [
                'order' => [100, OrderStatus::CODE_NEW],
                'payment' => [100],
                'client' => [
                    'status' => 400,
                ],
                'result' => [HttpCallPaymentHandler::ERROR_RESPONSE],
            ],
            [
                'order' => [100, OrderStatus::CODE_NEW],
                'payment' => [100],
                'client' => [
                    'status' => 500,
                ],
                'result' => [HttpCallPaymentHandler::ERROR_RESPONSE],
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
        $client = $this->createMock(ClientInterface::class);
        $client->method('request')->willReturn(new Response($data['client']['status']));

        return new HttpCallPaymentHandler($client, 'https://ya.ru');
    }
}
