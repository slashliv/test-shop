<?php

namespace App\Component\Logger;

use Psr\Log\AbstractLogger;

class FileLogger extends AbstractLogger
{
    /**
     * @var string
     */
    private $logDir;

    /**
     * @var bool
     */
    private $initialized = false;

    /**
     * @param string $logDir
     */
    public function __construct(string $logDir)
    {
        $this->logDir = $logDir;
    }

    private function initialize(): void
    {
        if ($this->initialized) {
            return;
        }

        if (!file_exists($this->logDir)) {
            mkdir($this->logDir, 0777, true);
        }

        $this->initialized = true;
    }

    /**
     * @inheritDoc
     */
    public function log($level, $message, array $context = array())
    {
        $this->initialize();

        $filename = $this->logDir . DIRECTORY_SEPARATOR . $level . '.log';
        file_put_contents($filename, $this->formatMessage($message), FILE_APPEND);
    }

    /**
     * @param string $message
     *
     * @return string
     */
    private function formatMessage(string $message)
    {
        return sprintf('[%s]: %s', date('Y-m-d H:i:s'), $message) . PHP_EOL;
    }
}