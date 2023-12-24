<?php

namespace Domain\Order\Providers;

use Domain\Order\Actions\NewOrderAction;
use Domain\Order\Actions\PutCouponInSessionAction;
use Domain\Order\Contracts\NewOrderContract;
use Domain\Order\Contracts\PutCouponInSessionContract;
use Illuminate\Support\ServiceProvider;

class ActionsServiceProvider extends ServiceProvider
{
    public array $bindings = [
        NewOrderContract::class => NewOrderAction::class,
        PutCouponInSessionContract::class => PutCouponInSessionAction::class,
    ];
}
