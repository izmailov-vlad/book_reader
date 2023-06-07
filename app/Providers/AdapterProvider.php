<?php

namespace App\Providers;

use App\Repository\BookAdapter;
use Carbon\Laravel\ServiceProvider;

class AdapterProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BookAdapter::class, function ($app) {
            return new BookAdapter();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
