<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\Auth\ForgotPasswordRequest;

class ForgotPasswordController extends Controller
{
    public function renderPage(): View
    {
        return view('auth.forgot-password');
    }

    public function handle(ForgotPasswordRequest $request): RedirectResponse
    {
        $status = Password::sendResetLink([
            'email' => $request->validated()['email']
        ]);
     
        return $status === Password::RESET_LINK_SENT
                ? back()->with(['message' => __($status)])
                : back()->withErrors(['email' => __($status)]);
    }
}