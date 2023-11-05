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

        if ($status != Password::RESET_LINK_SENT) {
            return back()->withErrors(['email' => __($status)]);
        }
        
        flash()->info(__($status));
        return back();
    }
}