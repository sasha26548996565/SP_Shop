<?php

declare(strict_types=1);

namespace Domain\Auth\Actions;

use Domain\Auth\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Domain\Auth\Contracts\RegisterNewUserContract;

final class RegisterNewUserAction implements RegisterNewUserContract
{
    public function __invoke(string $name, string $email, string $password): void
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        event(new Registered($user));
        Auth::login($user);
    }
}