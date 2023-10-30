<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function renderPage(): View
    {
        return view('auth.login');
    }

    public function handle(LoginRequest $request): RedirectResponse
    {
        $params = $request->validated();

        if (Auth::attempt($params)) {
            $request->session()->regenerate();
            return to_route('home');
        }

        return back()
            ->withErrors(['email' => 'Пользователь не найден'])
            ->onlyInput('email');
    }
}