<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Domain\Auth\Providers\AuthServiceProvider;
use Domain\Cart\Providers\CartServiceProvider;
use Domain\Catalog\Providers\CatalogServiceProvider;
use Domain\Product\Providers\ProductServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(
            CartServiceProvider::class
        );

        $this->app->register(
            AuthServiceProvider::class
        );

        $this->app->register(
            CatalogServiceProvider::class
        );

        $this->app->register(
            ProductServiceProvider::class
        );
    }
}
