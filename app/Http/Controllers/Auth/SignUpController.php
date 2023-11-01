<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignUpRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class SignUpController extends Controller
{
    public function renderPage(): View
    {
        return view('auth.sign-up');
    }

    public function handle(SignUpRequest $request): RedirectResponse
    {
        $params = $request->validated();

        $user = User::create([
            'name' => $params['name'],
            'email' => $params['email'],
            'password' => $params['password']
        ]);

        event(new Registered($user));
        Auth::login($user);
        return redirect()->intended(route('home'));
    }
}