<?php

declare(strict_types=1);

namespace Domain\Wishlist\StorageIdenties;

use Domain\Wishlist\Contracts\StorageIdentityContract;

final class SessionStorageIdentity implements StorageIdentityContract
{
    public function getId(): string
    {
        return session()->getId();
    }
}
