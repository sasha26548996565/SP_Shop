<?php

declare(strict_types=1);

namespace Domain\Auth\Actions;

use Domain\Auth\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Support\Session\FakeSessionRegenerator;
use Support\Session\SessionRegenerator;
use Support\Session\SessionRegeneratorContract;

final class RegisterNewUserAction implements RegisterNewUserContract
{
    public static function fake(): void
    {
        app()->bind(SessionRegeneratorContract::class, FakeSessionRegenerator::class);
    }

    public function __invoke(NewUserDTO $params): User
    {
        $user = User::create([
            'name' => $params->name,
            'email' => $params->email,
            'password' => Hash::make($params->password)
        ]);

        event(new Registered($user));
        //app(SessionRegenerator::class)->run(fn () => Auth::login($user));
        Auth::login($user);

        return $user;
    }
}
