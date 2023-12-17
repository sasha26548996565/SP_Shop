<?php

namespace Domain\Wishlist\Providers;

use Domain\Wishlist\Actions\AddOffer;
use Domain\Wishlist\Actions\CheckContainOffer;
use Domain\Wishlist\Actions\GetWishlist;
use Domain\Wishlist\Actions\RemoveOffer;
use Domain\Wishlist\Actions\UpdateStorageId;
use Domain\Wishlist\Contracts\AddOfferContract;
use Domain\Wishlist\Contracts\CheckContainOfferContract;
use Domain\Wishlist\Contracts\GetWishlistContract;
use Domain\Wishlist\Contracts\RemoveOfferContract;
use Domain\Wishlist\Contracts\UpdateStorageIdContract;
use Illuminate\Support\ServiceProvider;

class ActionsServiceProvider extends ServiceProvider
{
    public array $bindings = [
        AddOfferContract::class => AddOffer::class,
        GetWishlistContract::class => GetWishlist::class,
        UpdateStorageIdContract::class => UpdateStorageId::class,
        CheckContainOfferContract::class => CheckContainOffer::class,
        RemoveOfferContract::class => RemoveOffer::class,
    ];
}
