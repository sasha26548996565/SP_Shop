<?php

declare(strict_types=1);

namespace Domain\Wishlist\Actions;

use Domain\Product\Models\Offer;
use Domain\Wishlist\Contracts\RemoveOfferContract;
use LogicException;

final class RemoveOffer extends AbstractAction implements RemoveOfferContract
{
    public function __invoke(Offer $offer): void
    {
        $wishlist = $this->getWishlist();

        if ($wishlist == null) {
            throw new LogicException('Wishlist must be exists');
        }

        $wishlist->offers()->detach($offer);
    }
}
