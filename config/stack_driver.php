<?php

return [
    'log_name' => env('GCP_LOG_NAME', config('app.name')),
    'project_id' => env('GCP_PROJECT_ID'),
    'credentials' => env('GOOGLE_APPLICATION_CREDENTIALS'),
];
