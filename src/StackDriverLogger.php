<?php

namespace StackDriverLogger;

use Google\Cloud\Logging\LoggingClient;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StackDriverLogger
{
    /**
     * Google Cloud client logger
     *
     * @var $LoggingClient
     */
    protected $loggingClient;

    /**
     * Log
     *
     */
    protected $logger;

    public function __construct()
    {
        // Instantiates a client
        $this->loggingClient = new LoggingClient([
            'projectId' => config('stack_driver.project_id'),
            'keyFilePath' => config('stack_driver.key_file_path'),
            'requestTimeout' => config('stack_driver.request_timeout'),
            'retries' => config('stack_driver.retries'),
            'transport' => config('stack_driver.transport'),
        ]);

        // Selects the log to write to
        $this->logger = $this->loggingClient->logger(config('stack_driver.log_name'));
    }

    public function log($log)
    {
        if (gettype($log) == "object") {
            $code = (get_class($log) === NotFoundHttpException::class) ? $log->getStatusCode() : $log->getCode();

            $severity  = 'INFO';

            if ($code == 0 || $code == 500) {
                $severity = 'CRITICAL';
            }

            if ($code == 404) {
                $severity = 'WARNING';
            }

            // Creates the log entry
            $entry = $this->logger->entry($log->getMessage() . ' - Line: '. $log->getLine(). ' - File: '. $log->getFile() . ' - Code: '. $code, [
                'severity' => $severity,
                'labels' => [
                    'APP_NAME' => config('app.name'),
                    'APP_ENV' => config('app.env'),
                    'ERROR_CODE' => "$code",
                    'URL' => request()->url(),
                ],
            ]);

            // Writes the log entry
            $this->logger->write($entry);

            return;
        }

        // Creates the log entry
        $entry = $this->logger->entry($log);

        // Writes the log entry
        $this->logger->write($entry);
    }
}
