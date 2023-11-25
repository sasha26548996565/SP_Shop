<?php

declare(strict_types=1);

namespace Domain\Cart\StorageIdenties;

use Domain\Cart\Contracts\CartIdentityStorageContract;

class SessionIdentityStorage implements CartIdentityStorageContract
{
    public function getId(): string
    {
        return session()->getId();
    }
}
