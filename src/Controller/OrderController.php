<?php

namespace App\Controller;

use App\Entity\Order;
use App\Factory\OrderFactoryInterface;
use App\Output\ErrorsOutput;
use App\Payment\PaymentHandlerInterface;
use App\Input\OrderCreateInput;
use App\Input\PaymentInput;
use App\Output\OrderOutput;
use App\Component\Serializer\View;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends AbstractController
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function createAction(Request $request)
    {
        /** @var OrderCreateInput $input */
        $input = $this->getInput($request, OrderCreateInput::class);

        $order = $this->getOrderFactory()->create($input->getOrder());

        $this->getEntityManager()->persist($order);
        $this->getEntityManager()->flush();

        return $this->sendOutput(new OrderOutput(true, $order), ['orderCreate']);
    }

    /**
     * @param Request $request
     *
     * @return View|JsonResponse
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws EntityNotFoundException
     */
    public function payAction(Request $request)
    {
        /** @var PaymentInput $input */
        $input = $this->getInput($request, PaymentInput::class);

        $id = $request->attributes->get('id');
        $order = $this->getEntityManager()->getRepository(Order::class)
            ->getFull($request->attributes->get('id'))
        ;

        if (null === $order) {
            throw new EntityNotFoundException(sprintf(
                'Entity %s with id=%d not found',
                Order::class,
                $id
            ));
        }

        $handlerErrors = $this->getPaymentHandler()->handle($order, $input->getPayment());
        if (!empty($handlerErrors)) {
            return $this->sendOutput(new ErrorsOutput($handlerErrors), [], 400);
        }

        $this->getEntityManager()->flush();

        return $this->sendOutput(
            new OrderOutput(true, $order),
            ['pay']
        );
    }

    /**
     * @return OrderFactoryInterface
     */
    private function getOrderFactory(): OrderFactoryInterface
    {
        return $this->container->get('factory.order');
    }

    /**
     * @return PaymentHandlerInterface
     */
    private function getPaymentHandler(): PaymentHandlerInterface
    {
        return $this->container->get('handler.payment');
    }
}