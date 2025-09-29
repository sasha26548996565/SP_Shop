<?php

declare(strict_types=1);

namespace App\Providers;

use App\Filters\BrandFilter;
use App\Filters\PriceFilter;
use App\Filters\OptionValueFilter;
use Domain\Catalog\Sorters\Sorter;
use Illuminate\Support\ServiceProvider;
use Domain\Catalog\Filters\FilterManager;

class CatalogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(FilterManager::class);
    }

    public function boot(): void
    {
        if (! app()->runningInConsole()) {
            app(FilterManager::class)->setFilterItems([
                new PriceFilter(),
                new BrandFilter(),
                new OptionValueFilter(),
            ]);
        }

        $this->app->bind(Sorter::class, function () {
            return new Sorter([
                'title',
                'price'
            ]);
        });
    }
}
