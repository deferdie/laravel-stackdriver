# Laravel Stackdriver

### Installation:

    composer require deferdie/laravel-stackdriver

### Add the following enviroment variables to your .env file
    
    GCP_PROJECT_ID=YOUR GOOGLE CLOUD PROJECT ID
    GCP_LOG_NAME=YOUR LOG NAME <YOUR LARAVEL PROJECT NAME>
    GOOGLE_APPLICATION_CREDENTIALS=PATH TO YOUR CREDIENTIAL.JSON FILE

To optain a JSON file containing your credientials, you first need to create a google service account and get a key file from the IAM section.

### In your config/app.php within your providers array
    
    StackDriverLogger\LaravelStackDriverServiceProvider::class,

### In your app/Exceptions/Handler.php

    use StackDriverLogger\StackDriverLogger;

and finally within the report function

    $log = new StackDriverLogger();
    $log->log($exception);