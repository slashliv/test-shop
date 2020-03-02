<?php

namespace App;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Application extends BaseApplication
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param Kernel $kernel
     */
    public function __construct(Kernel $kernel)
    {
        parent::__construct('test', '1.0');

        $this->container = $kernel->getContainer();
    }

    /**
     * @inheritDoc
     */
    protected function doRunCommand(Command $command, InputInterface $input, OutputInterface $output)
    {
        if ($command instanceof ContainerAwareInterface) {
            $command->setContainer($this->container);
        }

        return parent::doRunCommand($command, $input, $output);
    }
}
