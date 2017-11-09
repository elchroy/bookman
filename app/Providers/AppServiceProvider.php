<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\UserService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserService::class, function () {
        	$server = new \SoapServer(null, [
				'uri' => url('/'),
        	]);
        	return new UserService ($server);
        });
    }
}
