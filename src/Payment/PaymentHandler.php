<?php

namespace App\Payment;

use App\Entity\Order;

class PaymentHandler implements PaymentHandlerInterface
{
    /**
     * @var PaymentHandlerInterface[]
     */
    private $handlers;

    public function __construct()
    {
        $this->handlers = [];
    }

    /**
     * @param PaymentHandlerInterface $handler
     */
    public function addHandler(PaymentHandlerInterface $handler)
    {
        $this->handlers[] = $handler;
    }

    /**
     * @inheritDoc
     */
    public function handle(Order $order, PaymentInterface $payment): array
    {
        foreach ($this->handlers as $handler) {
            $handlerResult = $handler->handle($order, $payment);
            if (!empty($handlerResult)) {
                return $handlerResult;
            }
        }

        return [];
    }
}
