<?php

namespace StackDriverLogger;

use Illuminate\Support\ServiceProvider;

class LaravelStackDriverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/stack_driver.php' => config_path('stack_driver.php'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('deferdie-StackDriverLogger', function () {
            return new StackDriverLogger();
        });
    }
}
