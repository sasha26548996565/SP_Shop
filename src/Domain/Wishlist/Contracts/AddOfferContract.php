<?php

declare(strict_types=1);

namespace Domain\Wishlist\Contracts;

use Domain\Product\Models\Offer;

interface AddOfferContract
{
    public function __invoke(Offer $offer): void;
}
