<?php

namespace App\Component\Routing;

use App\Component\Kernel\RequestStorageInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;

class RouterFactory
{
    /**
     * @var RequestStorageInterface
     */
    private $requestStorage;

    /**
     * @var string
     */
    private $configDir;

    /**
     * @param RequestStorageInterface $requestStorage
     * @param string $configDir
     */
    public function __construct(RequestStorageInterface $requestStorage, string $configDir)
    {
        $this->requestStorage = $requestStorage;
        $this->configDir = $configDir;
    }

    /**
     * @return RouterInterface
     */
    public function create(): RouterInterface
    {
        $fileLocator = new FileLocator($this->configDir);
        $loader = new YamlFileLoader($fileLocator);

        $request = $this->requestStorage->getRequest();
        $requestContext = new RequestContext();
        $requestContext->fromRequest($request);

        return new Router($loader, 'routes.yaml', [], $requestContext);
    }
}
