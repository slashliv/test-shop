<?php

namespace App\Component\Doctrine;

use Doctrine\Common\Cache\CacheProvider;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Yaml\Yaml;

class EntityManagerFactory implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @var string
     */
    private $doctrineConfigFile;

    /**
     * @var array
     */
    private $config;

    /**
     * @var bool
     */
    private $initialized = false;

    /**
     * @param string $configFile
     */
    public function __construct(string $configFile)
    {
        $this->doctrineConfigFile = $configFile;
    }

    private function initialize()
    {
        if ($this->initialized) {
            return;
        }

        $this->config = Yaml::parseFile($this->doctrineConfigFile);

        $this->initialized = true;
    }

    /**
     * @return EntityManagerInterface
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(): EntityManagerInterface
    {
        $this->initialize();

        $entityManager = EntityManager::create(
            $this->getConnectionConfig(),
            $this->getOrmConfig()
        );

        return $entityManager;
    }

    /**
     * @return \Doctrine\ORM\Configuration
     */
    private function getOrmConfig()
    {
        return Setup::createAnnotationMetadataConfiguration(
            array($this->getEntityDir()),
            true,
            null,
            $this->getCache(),
            false
        );
    }

    /**
     * @return CacheProvider
     */
    private function getCache(): CacheProvider
    {
        return $this->container->get('cache');
    }

    /**
     * @return string
     */
    private function getEntityDir(): string
    {
        return $this->container->getParameter('kernel.src_dir')
            . DIRECTORY_SEPARATOR
            . $this->config['orm']['entity_dir']
        ;
    }

    /**
     * @return array
     */
    private function getConnectionConfig(): array
    {
        $connectionConfig = $this->config['connection'];

        $normalizedConnectionConfig = [];
        foreach ($connectionConfig as $key => $parameter) {
            $parameter = trim($parameter, '%');
            if ($this->container->hasParameter($parameter)) {
                $parameter = $this->container->getParameter($parameter);
            }

            $normalizedConnectionConfig[$key] = $parameter;
        }

        if (null !== $normalizedConnectionConfig['schema'] ?? null) {
            $normalizedConnectionConfig['schema'] = 'public';
        }

        return $normalizedConnectionConfig;
    }
}
