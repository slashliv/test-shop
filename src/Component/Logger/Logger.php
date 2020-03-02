<?php

namespace App\Component\Logger;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class Logger extends AbstractLogger
{
    /**
     * @var bool
     */
    private $debug;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var NullLogger
     */
    private $nullLogger;

    /**
     * @param bool $debug
     * @param LoggerInterface $logger
     * @param LoggerInterface $nullLogger
     */
    public function __construct(bool $debug, LoggerInterface $logger, LoggerInterface $nullLogger)
    {
        $this->debug = $debug;
        $this->logger = $logger;
        $this->nullLogger = $nullLogger;
    }

    /**
     * @inheritDoc
     */
    public function log($level, $message, array $context = array())
    {
        if ($this->debug) {
            $this->logger->log($level, $message, $context);

            return;
        }

        $this->nullLogger->log($level, $message, $context);
    }
}