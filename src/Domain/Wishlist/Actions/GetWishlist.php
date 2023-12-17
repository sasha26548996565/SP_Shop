<?php

declare(strict_types=1);

namespace Domain\Wishlist\Actions;

use Domain\Wishlist\Contracts\GetWishlistContract;
use Domain\Wishlist\Models\Wishlist;
use Illuminate\Database\Eloquent\Builder;

final class GetWishlist extends AbstractAction implements GetWishlistContract
{
    public function __invoke(): ?Wishlist
    {
        return Wishlist::query()
            ->where('storage_id', $this->storageIdentity->getId())
            ->when(auth()->check(), function (Builder $query) {
                $query->orWhere('user_id', auth()->id());
            })
            ->first();
    }
}
