<?php

declare(strict_types=1);

namespace Domain\Wishlist\Actions;

use Domain\Product\Models\Offer;
use Domain\Wishlist\Contracts\CheckContainOfferContract;
use Domain\Wishlist\Models\Wishlist;

final class CheckContainOffer extends AbstractAction implements CheckContainOfferContract
{
    public function __invoke(Offer $offer): bool
    {
        $wishlist = $this->getWishlist();

        if ($wishlist == null) {
            return false;
        }

        return $wishlist->offers->contains($offer->id);
    }
}
