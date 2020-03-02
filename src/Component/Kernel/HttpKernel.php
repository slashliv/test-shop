<?php

namespace App\Component\Kernel;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class HttpKernel implements HttpKernelInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @inheritDoc
     */
    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        [$controller, $method] = $this->getControllerResolver()->getController($request);
        if ($controller instanceof ContainerAwareInterface) {
            $controller->setContainer($this->container);
        }

        $controllerResult = call_user_func([$controller, $method], $request);
        if ($controllerResult instanceof Response) {
            return $controllerResult;
        }

        throw new \RuntimeException(sprintf(
            'Controller must return instance of %s',
            Response::class
        ));
    }

    /**
     * @return ControllerResolverInterface
     */
    private function getControllerResolver(): ControllerResolverInterface
    {
        return $this->container->get('controller_resolver');
    }
}
