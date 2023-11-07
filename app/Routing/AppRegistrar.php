<?php

declare(strict_types=1);

namespace App\Routing;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Contracts\RouteRegistrarContract;
use Illuminate\Contracts\Routing\Registrar;

final class AppRegistrar implements RouteRegistrarContract
{
    public function map(Registrar $registrar): void
    {
        Route::middleware('web')->group(function () {
            Route::get('/', HomeController::class)->name('home');
        });
    }
}