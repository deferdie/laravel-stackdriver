<?php

namespace StackDriverLogger;

use Google\Cloud\Logging\LoggingClient;

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
        $this->project_id = env('GCP_PROJECT_ID');

        // Instantiates a client
        $this->loggingClient = new LoggingClient([
            'projectId' => $this->project_id
        ]);

        // The name of the log to write to
        $this->logName = env('GCP_LOG_NAME');

        // Selects the log to write to
        $this->logger = $this->loggingClient->logger($this->logName);
    }

    public function log($log)
    {
        if (gettype($log) == "object") {

            $code = $log->getCode();

            $severity  = 'INFO';

            if ($code == 0 || $code == 500) {
                $severity = 'CRITICAL';
            }
            
            if ($code == 404) {
                $severity = 'WARNING';
            }

            // Creates the log entry
            $entry = $this->logger->entry($log->getMessage() . ' - Line: '. $log->getLine(), [
                'severity' => $severity
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