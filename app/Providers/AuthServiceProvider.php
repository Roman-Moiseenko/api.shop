<?php

namespace App\Providers;


use App\Modules\Auth\Contracts\AuthServiceContract;
use App\Modules\Auth\Service\AuthServiceFactory;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AuthServiceContract::class, function () {
            return AuthServiceFactory::create();
        });
    }
}
