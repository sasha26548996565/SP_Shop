<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Support\SessionRegenerator;

class LogoutController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        app(SessionRegenerator::class)->run(fn () => Auth::logout());

        return redirect()
            ->intended(route('home'));
    }
}
