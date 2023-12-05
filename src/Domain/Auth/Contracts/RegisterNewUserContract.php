<?php

declare(strict_types=1);

namespace Domain\Auth\Contracts;

use Domain\Auth\DTOs\NewUserDTO;
use Domain\Auth\Models\User;

interface RegisterNewUserContract
{
    public function __invoke(NewUserDTO $params): User;
}
