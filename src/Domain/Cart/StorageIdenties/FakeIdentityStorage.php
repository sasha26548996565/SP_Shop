<?php

declare(strict_types=1);

namespace Domain\Cart\StorageIdenties;

use Domain\Cart\Contracts\CartIdentityStorageContract;

class FakeIdentityStorage implements CartIdentityStorageContract
{
    public function getId(): string
    {
        return 'test';
    }
}
