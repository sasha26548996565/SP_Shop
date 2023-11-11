<?php

declare(strict_types=1);

namespace App\Routing;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Contracts\RouteRegistrarContract;
use App\Http\Controllers\ThumbnailController;
use Illuminate\Contracts\Routing\Registrar;

final class AppRegistrar implements RouteRegistrarContract
{
    public function map(Registrar $registrar): void
    {
        Route::middleware('web')->group(function () {
            Route::get('/', HomeController::class)->name('home');
            Route::get('/storage/images/{directory}/{method}/{size}/{file}', ThumbnailController::class)
                ->where('method', 'resize|fit|crop')
                ->where('size', '\d+x\d+')
                ->name('thumbnail');
        });
    }
}
