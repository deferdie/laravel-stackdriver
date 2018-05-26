<?php

namespace StackDriverLogger;

use Illuminate\Support\ServiceProvider;

class StackDriverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        require __DIR__.'/routes/routes.php';
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('stackdriver-logger', function() {
            return new StackDriverLogger();
        });
    }
}