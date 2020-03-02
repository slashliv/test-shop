<?php

namespace App\Command;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class LoadInitialFixturesCommand extends ContainerAwareCommand
{
    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this
            ->setName('fixtures:load:initial')
            ->addOption('append', null, InputOption::VALUE_NONE)
        ;
    }

    /**
     * @inheritDoc
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $loader = new Loader();
        $loader->loadFromDirectory(__DIR__ . '/../DataFixtures/Initial');

        $purger = new ORMPurger();

        $executor = new ORMExecutor($this->container->get('entity_manager'), $purger);
        $executor->execute($loader->getFixtures(), $input->getOption('append'));

        $output->writeln('<info>Fixtures were loaded</info>');
    }
}
