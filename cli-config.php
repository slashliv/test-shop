<?php

use App\Kernel;

require_once "bootstrap.php";

$kernel = new Kernel();

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet(
    $kernel->getContainer()->get('entity_manager')
);
