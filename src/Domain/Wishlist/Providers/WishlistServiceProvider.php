<?php

namespace Domain\Wishlist\Providers;

use Domain\Wishlist\Actions\AbstractAction;
use Domain\Wishlist\Contracts\StorageIdentityContract;
use Domain\Wishlist\StorageIdenties\SessionStorageIdentity;
use Illuminate\Support\ServiceProvider;

class WishlistServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(
            ActionsServiceProvider::class
        );

        $this->app->singleton(AbstractAction::class, function () {
            return new AbstractAction(new SessionStorageIdentity());
        });

        $this->app->bind(StorageIdentityContract::class, SessionStorageIdentity::class);
    }
}
