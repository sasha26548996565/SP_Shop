<?php

declare(strict_types=1);

namespace App\Routing;

use App\Contracts\RouteRegistrarContract;
use App\Http\Controllers\CartController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

final class CartRegistrar implements RouteRegistrarContract
{
    public function map(Registrar $registrar): void
    {
        Route::middleware('web')->group(function () {
            Route::name('cart')->prefix('cart')->group(function () {
                Route::get('/', [CartController::class, 'index']);

                Route::post('/add/{offer}', [CartController::class, 'addItem'])
                    ->name('.add');

                Route::post('/quantity/{cartItem}', [CartController::class, 'updateQuantity'])
                    ->name('.quantity');

                Route::post('/remove/{cartItem}', [CartController::class, 'removeItem'])
                    ->name('.remove');

                Route::post('/clear', [CartController::class, 'clear'])
                    ->name('.clear');
            });
        });
    }
}
