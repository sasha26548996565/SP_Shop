<?php

declare(strict_types=1);

namespace App\Routing;

use App\Contracts\RouteRegistrarContract;
use App\Http\Controllers\ProductController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

final class ProductRegistrar implements RouteRegistrarContract
{
    public function map(Registrar $registrar): void
    {
        Route::middleware('web')->group(function () {
            Route::get('/product/{product:slug}', [ProductController::class, 'show'])
                ->name('product');
        });
    }
}
