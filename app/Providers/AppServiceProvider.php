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
        $server = new \SoapServer(null, [
            'uri' => url('/'),
        ]);
        
        $this->app->singleton(UserService::class, function () use ($server) {
            $repo = new UserRepository();
            return new UserService ($server, $repo);
        });

        $this->app->singleton(BookService::class, function () use ($server) {
            $repo = new BookRepository();
            return new BookService ($server, $repo);
        });
    }
}
