<?php

declare(strict_types=1);

namespace Domain\Order\Actions;

use Domain\Order\Contracts\PutCouponInSessionContract;

class PutCouponInSessionAction implements PutCouponInSessionContract
{
    public function __invoke(int $couponId): void
    {
        session()->put('coupon_id', $couponId);
    }
}
