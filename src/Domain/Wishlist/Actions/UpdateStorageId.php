<?php

declare(strict_types=1);

namespace Domain\Wishlist\Actions;

use Domain\Wishlist\Contracts\UpdateStorageIdContract;
use Domain\Wishlist\Models\Wishlist;

final class UpdateStorageId extends AbstractAction implements UpdateStorageIdContract
{
    public function __invoke(string $oldId, string $newId): void
    {
        Wishlist::where('storage_id', $oldId)
            ->update($this->generateParams($newId));
    }
}
