<?php

namespace StackDriverLogger;

use Google\Cloud\Logging\LoggingClient;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StackDriverLogger
{
    /**
     * Google Cloud Platform project ID
     *
     * @var $string
     */
    protected $project_id;

    /**
     * Google Cloud client logger
     *
     * @var $LoggingClient
     */
    protected $loggingClient;

    /**
     * Log name
     *
     * @var $string
     */
    protected $logName;

    /**
     * Log
     *
     */
    protected $logger;

    public function __construct()
    {
        $this->project_id = config('stack_driver.project_id');

        // Instantiates a client
        $this->loggingClient = new LoggingClient([
            'projectId' => $this->project_id,
            'keyFilePath' => config('stack_driver.credentials'),
        ]);

        // The name of the log to write to
        $this->logName = config('stack_driver.log_name');

        // Selects the log to write to
        $this->logger = $this->loggingClient->logger($this->logName);
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
                    'URL' => request()->url() ?: 'Not Found'
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
