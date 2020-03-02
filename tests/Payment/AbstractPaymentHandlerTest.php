<?php

namespace App\Tests\Payment;

use App\DTO\PaymentDTO;
use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\OrderStatus;
use App\Entity\Product;
use App\Payment\PaymentHandlerInterface;
use PHPUnit\Framework\TestCase;

abstract class AbstractPaymentHandlerTest extends TestCase
{
    /**
     * @param array $data
     *
     * @return PaymentHandlerInterface
     */
    abstract protected function createHandler(array $data = []): PaymentHandlerInterface;

    /**
     * @param float $sum
     *
     * @return Order
     */
    protected function createOrder(float $sum, string $statusCode)
    {
        $product = new Product();
        $product
            ->setPrice($sum)
            ->setName('Product1')
        ;

        $orderProduct = new OrderProduct();
        $orderProduct
            ->setProduct($product)
            ->setQuantity(1)
            ->setPrice($sum)
        ;

        $orderStatus = $this->createOrderStatus($statusCode);

        $order = new Order();

        return $order
            ->setStatus($orderStatus)
            ->addProduct($orderProduct)
        ;
    }

    /**
     * @param string $statusCode
     *
     * @return OrderStatus
     */
    protected function createOrderStatus(string $statusCode)
    {
        $orderStatus = new OrderStatus();

        return $orderStatus
            ->setCode($statusCode)
            ->setName($statusCode)
        ;
    }

    /**
     * @param float $sum
     *
     * @return PaymentDTO
     */
    protected function createPayment(float $sum)
    {
        $payment = new PaymentDTO();
        $payment->setSum($sum);

        return $payment;
    }
}
