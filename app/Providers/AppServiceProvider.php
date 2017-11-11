<?php

namespace App\Providers;

use App\Services\UserService;
use App\Services\BookService;
use Illuminate\Support\ServiceProvider;
use App\Repositories\V1\BookRepository;
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
        $this->app->singleton(\SoapServer::class, function () {
            return new \SoapServer(null, [
                'uri' => url('/')
            ]);
        });
    }
}
