<?php

namespace Domain\Wishlist\Providers;

use Domain\Wishlist\Actions\AddOffer;
use Domain\Wishlist\Actions\GetWishlist;
use Domain\Wishlist\Contracts\AddOfferContract;
use Domain\Wishlist\Contracts\GetWishlistContract;
use Illuminate\Support\ServiceProvider;

class ActionsServiceProvider extends ServiceProvider
{
    public array $bindings = [
        AddOfferContract::class => AddOffer::class,
        GetWishlistContract::class => GetWishlist::class,
    ];
}
