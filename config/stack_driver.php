<?php

return [
    'log_name' => env('GCP_LOG_NAME', config('app.name')),
    // The project ID from the Google Developer's Console.
    'project_id' => env('GCP_PROJECT_ID'),
    // The full path to your service account credentials .json file retrieved from the Google Developers Console.
    'key_file_path' => env('GOOGLE_APPLICATION_CREDENTIALS'),
    // Seconds to wait before timing out the request.
    // **Defaults to** `0` with REST and `60` with gRPC.
    'request_timeout' => 0,
    // Number of retries for a failed request.
    'retries' => 3,
    // The transport type used for requests.
    // May be either `grpc` or `rest`.
    // **Defaults to** `grpc` if gRPC support  is detected on the system.
    'transport' => null
];
