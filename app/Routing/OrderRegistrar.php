<?php

declare(strict_types=1);

namespace App\Routing;

use App\Contracts\RouteRegistrarContract;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\OrderController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

final class OrderRegistrar implements RouteRegistrarContract
{
    public function map(Registrar $registrar): void
    {
        Route::middleware('web')->group(function () {
            Route::controller(OrderController::class)->prefix('order')->name('order')->group(function () {
                Route::get('/', 'index');

                Route::post('/', 'handle')
                    ->name('.handle');
            });

            Route::controller(CouponController::class)->name('coupon.')->prefix('coupon')->group(function () {
                Route::post('/put', 'putCouponInSession')
                    ->name('putInSession');
            });
        });
    }
}
