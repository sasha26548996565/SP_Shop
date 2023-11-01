<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth\Socialite;

use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

class GithubController extends Controller
{
    public function github(): RedirectResponse
    {
        return Socialite::driver('github')->redirect();
    }

    public function githubCallback(): RedirectResponse
    {
        $githubUser = Socialite::driver('github')->user();

        $user = User::updateOrCreate([
            'github_id' => $githubUser->id,
        ], [
            'name' => $githubUser->nickname ?? $githubUser->email,
            'email' => $githubUser->email,
            'password' => Hash::make(Str::random(8))
        ]);
     
        Auth::login($user);
     
        return redirect()
            ->intended(route('home'));
    }
}