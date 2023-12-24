<?php

declare(strict_types=1);

namespace Domain\Order\Contracts;

interface PutCouponInSessionContract
{
    public function __invoke(int $couponId): void;
}
