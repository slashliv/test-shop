<?php

namespace App\Component\Kernel;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class Kernel implements HttpKernelInterface
{
    /**
     * @var bool
     */
    private $initialized = false;

    /**
     * @var string
     */
    private $projectDir;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @inheritDoc
     */
    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        $this->initialize();

        try {
            $this->getRequestStorage()->setRequest($request);

            return $this->doHandle($request, $type, $catch);
        } catch (\Throwable $throwable) {
            return $this->handleThrowable($throwable);
        }
    }

    /**
     * @param Request $request
     * @param int $type
     * @param bool $catch
     *
     * @return Response
     *
     * @throws \Exception
     */
    private function doHandle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        $params = $this->getRouter()->matchRequest($request);
        $request->attributes->add($params);

        return $this->getHttpKernel()->handle($request, $type, $catch);
    }

    private function initialize()
    {
        if ($this->initialized) {
            return;
        }

        AnnotationRegistry::registerLoader('class_exists');
        $this->initializeContainer();
        $this->initialized  = true;
    }

    private function initializeContainer()
    {
        if (null !== $this->container) {
            return;
        }

        $this->container = new ContainerBuilder();
        $this->container->setParameter('kernel.project_dir', $this->getProjectDir());
        $this->container->setParameter('kernel.config_dir', $this->getConfigDir());
        $this->container->setParameter('kernel.src_dir', $this->getSrcDir());
        $this->container->setParameter('kernel.logs_dir', $this->getLogsDir());

        $loader = new YamlFileLoader($this->container, new FileLocator($this->getConfigDir()));
        $loader->load('services.yaml');
        $loader->load('parameters.yaml');

        foreach ($this->getCompilerPasses() as $compilerPass) {
            $compilerPass->process($this->container);
        }
    }

    /**
     * @return CompilerPassInterface[]
     */
    protected function getCompilerPasses(): array
    {
        return [];
    }

    /**
     * Returns project directory
     *
     * @return string
     */
    protected function getProjectDir(): string
    {
        if (null === $this->projectDir) {
            $reflection = new \ReflectionClass(get_called_class());

            $this->projectDir = dirname(dirname($reflection->getFileName()));
        }

        return $this->projectDir;
    }

    /**
     * @return LoggerInterface
     */
    private function getLogger(): LoggerInterface
    {
        return $this->container->get('logger');
    }

    /**
     * Returns src directory
     *
     * @return string
     */
    protected function getSrcDir(): string
    {
        return $this->getProjectDir() . '/src';
    }

    /**
     * Returns config directory
     *
     * @return string
     */
    protected function getConfigDir(): string
    {
        return $this->getProjectDir() . '/config';
    }

    /**
     * Returns config directory
     *
     * @return string
     */
    protected function getLogsDir(): string
    {
        return $this->getProjectDir() . '/var/logs';
    }

    /**
     * @return RequestStorageInterface
     */
    private function getRequestStorage(): RequestStorageInterface
    {
        return $this->container->get('request_storage');
    }

    private function getRouter()
    {
        return $this->container->get('router');
    }

    /**
     * @return HttpKernelInterface
     */
    private function getHttpKernel(): HttpKernelInterface
    {
        return $this->container->get('http_kernel');
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        $this->initialize();

        return $this->container;
    }

    /**
     * @param \Throwable $throwable
     *
     * @return Response
     *
     * @throws \Throwable
     */
    private function handleThrowable(\Throwable $throwable)
    {
        if ($this->isDebug()) {
            $this->getLogger()->critical($throwable->getMessage());

            throw $throwable;
        }

        return $this->createThrowableResponse($throwable);
    }

    /**
     * @param \Throwable $throwable
     *
     * @return Response
     */
    private function createThrowableResponse(\Throwable $throwable): Response
    {
        $errorMessage = 'Internal server error';
        $status = 500;
        if ($this->isDebug()) {
            $status = 400;
            $errorMessage = $throwable->getMessage();
        }

        $data = [
            'success' => false,
            'error' => $errorMessage,
        ];

        return new JsonResponse($data, $status);
    }

    /**
     * @return bool
     */
    public function isDebug(): bool
    {
        return $this->container->getParameter('debug');
    }
}
