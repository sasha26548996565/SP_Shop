<?php

declare(strict_types=1);

namespace Domain\Wishlist\Actions;

use Domain\Product\Models\Offer;
use Domain\Wishlist\Contracts\AddOfferContract;
use Domain\Wishlist\Models\Wishlist;

final class AddOffer extends AbstractAction implements AddOfferContract
{
    public function __invoke(Offer $offer): void
    {
        $wishlist = Wishlist::updateOrCreate([
            'storage_id' => $this->storageIdentity->getId(),
        ], $this->generateParams($this->storageIdentity->getId()));

        $wishlist->offers()->attach($offer->id);
    }
}
