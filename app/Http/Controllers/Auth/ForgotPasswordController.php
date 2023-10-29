<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class ForgotPasswordController extends Controller
{
    public function renderPage(): View
    {
        return view('auth.forgot-password');
    }
}