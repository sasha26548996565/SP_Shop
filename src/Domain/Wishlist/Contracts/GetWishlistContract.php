<?php

declare(strict_types=1);

namespace Domain\Wishlist\Contracts;

use Domain\Wishlist\Models\Wishlist;

interface GetWishlistContract
{
    public function __invoke(): ?Wishlist;
}
