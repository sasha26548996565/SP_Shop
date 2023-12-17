<?php

declare(strict_types=1);

namespace App\Routing;

use App\Contracts\RouteRegistrarContract;
use App\Http\Controllers\WishlistController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

final class WishlistRegistrar implements RouteRegistrarContract
{
    public function map(Registrar $registrar): void
    {
        Route::middleware('web')->group(function () {
            Route::controller(WishlistController::class)->name('wishlist')->prefix('wishlist')->group(function () {
                Route::middleware('wishlist.not.empty')->group(function () {
                    Route::get('/', 'index');
                    Route::post('/remove/{offer}', 'removeOffer')->name('.remove');
                });

                Route::post('/add/{offer}', 'addOffer')->name('.add');
            });
        });
    }
}
