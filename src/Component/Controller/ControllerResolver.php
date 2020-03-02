<?php

namespace App\Component\Controller;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;

class ControllerResolver implements ControllerResolverInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @inheritDoc
     */
    public function getController(Request $request)
    {
        $controllerResource = $request->attributes->get('_controller');
        [$controller, $controllerMethod] = explode(':', $controllerResource);

        if ($this->container->has($controller)) {
            return [$this->container->get($controller), $controllerMethod];
        }

        if (class_exists($controller)) {
            return [new $controller(), $controllerMethod];
        }

        if (is_callable([$controller, $controllerMethod])) {
            return [$controller, $controllerMethod];
        }

        throw new \InvalidArgumentException(sprintf(
            'The controller for URI "%s" is not callable.',
            $request->getPathInfo()
        ));
    }
}
