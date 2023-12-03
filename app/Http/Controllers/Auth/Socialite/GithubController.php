<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth\Socialite;

use Illuminate\Support\Str;
use Domain\Auth\Models\User;
use Support\Session\SessionRegenerator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

class GithubController extends Controller
{
    public function github(): RedirectResponse
    {
        try {
            return Socialite::driver('github')->redirect();
        } catch (\Throwable $error) {
            throw new \DomainException('Произошла ошибка или драйвер не поддерживается');
        }
    }

    public function githubCallback(): RedirectResponse
    {
        $githubUser = Socialite::driver('github')->user();

        $user = User::updateOrCreate([
            'github_id' => $githubUser->getId(),
        ], [
            'name' => $githubUser->getNickName() ?? $githubUser->getEmail(),
            'email' => $githubUser->getEmail(),
            'password' => Hash::make(Str::random(8))
        ]);

        app(SessionRegenerator::class)->run(fn () => Auth::login($user));

        return redirect()
            ->intended(route('home'));
    }
}
