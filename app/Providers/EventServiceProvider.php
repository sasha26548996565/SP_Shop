<?php

declare(strict_types=1);

namespace App\Providers;

use App\Listeners\SendEmailNewUserListener;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Domain\Catalog\Observers\BrandObserver;
use Domain\Catalog\Observers\CategoryObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            //SendEmailVerificationNotification::class,
            SendEmailNewUserListener::class,
        ],
    ];

    public function boot(): void
    {
        Brand::observe(BrandObserver::class);
        Category::observe(CategoryObserver::class);
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}