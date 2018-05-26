<?php

namespace ExceptionLogger\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelStackDriverFacade extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'laravel-stackdriver-logger';
	}
}