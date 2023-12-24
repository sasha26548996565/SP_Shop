<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Coupon\PutCouponRequest;
use Domain\Order\Contracts\PutCouponInSessionContract;
use Domain\Order\Models\Coupon;

class CouponController extends Controller
{
    public function putCouponInSesssion(PutCouponRequest $request, PutCouponInSessionContract $putCoupon): RedirectResponse
    {
        $coupon = Coupon::where('name', $request->validated()['name'])
            ->first();

        $putCoupon($coupon->id);

        return redirect()
            ->intended(route('home'));
    }
}
