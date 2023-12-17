<?php

declare(strict_types=1);

namespace Domain\Wishlist\Contracts;

interface StorageIdentityContract
{
    public function getId(): string;
}
