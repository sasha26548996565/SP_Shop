<?php

declare(strict_types=1);

namespace App\Providers;

use App\Listeners\SendEmailNewUserListener;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Domain\Catalog\Observers\BrandObserver;
use Domain\Catalog\Observers\CategoryObserver;
use Domain\Order\Events\AfterSessionRegistered;
use Domain\Wishlist\Contracts\UpdateStorageIdContract;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailNewUserListener::class,
        ],
    ];

    public function boot(): void
    {
        Brand::observe(BrandObserver::class);
        Category::observe(CategoryObserver::class);

        Event::listen(AfterSessionRegistered::class, function (AfterSessionRegistered $event) {
            cart()->updateIdentityStorage(
                $event->oldSessionId,
                $event->currentSessionId
            );

            $updateStorageId = app(UpdateStorageIdContract::class);
            $updateStorageId($event->oldSessionId, $event->currentSessionId);
        });
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
