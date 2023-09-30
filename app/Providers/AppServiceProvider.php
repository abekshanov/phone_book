<?php

namespace App\Providers;

use App\Contracts\Controllers\Factories\ControllerFactoryInterface;
use App\Http\Controllers\Api\v1\Contacts\ContactController;
use App\Services\AbstractFactories\Controllers\Contacts\ContactFactory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->when(ContactController::class)
            ->needs(ControllerFactoryInterface::class)
            ->give(ContactFactory::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
