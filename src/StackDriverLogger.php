<?php

namespace StackDriverLogger;

use Google\Cloud\Logging\LoggingClient;

class ClientExceptionLogger
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
        $this->project_id = env('GCP_project_id');

        // Instantiates a client
        $this->loggingClient = new LoggingClient([
            'projectId' => $this->project_id
        ]);

        // The name of the log to write to
        $this->logName = env('GCP_log_name');

        // Selects the log to write to
        $this->logger = $this->loggingClient->logger($logName);
    }

    public function log($log)
    {
        # Creates the log entry
        $entry = $this->logger->entry($log);

        # Writes the log entry
        $logger->write($entry);
    }
}