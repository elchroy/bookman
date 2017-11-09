<?php

namespace App\Providers;

use App\Services\UserService;
use Illuminate\Support\ServiceProvider;
use App\Repositories\V1\UserRepository;

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
        	$repo = new UserRepository();
        	return new UserService ($server, $repo);
        });
    }
}
