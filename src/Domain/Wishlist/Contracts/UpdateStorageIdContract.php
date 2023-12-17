<?php

declare(strict_types=1);

namespace Domain\Wishlist\Contracts;

interface UpdateStorageIdContract
{
    public function __invoke(string $oldId, string $newId): void;
}
