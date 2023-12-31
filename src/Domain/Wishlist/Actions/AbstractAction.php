<?php

declare(strict_types=1);

namespace Domain\Wishlist\Actions;

use Domain\Wishlist\Contracts\StorageIdentityContract;
use Domain\Wishlist\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class AbstractAction
{
    public function __construct(
        protected StorageIdentityContract $storageIdentity
    ) {
    }

    protected function generateParams(string $storageId): array
    {
        $params = [
            'storage_id' => $storageId
        ];

        if (Auth::check()) {
            $params['user_id'] = Auth::id();
        }

        return $params;
    }

    protected function getWishlist(): ?Wishlist
    {
        return Wishlist::where('storage_id', $this->storageIdentity->getId())
            ->first();
    }
}
