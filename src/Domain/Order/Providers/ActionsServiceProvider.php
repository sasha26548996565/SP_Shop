<?php

namespace Domain\Order\Providers;

use Domain\Order\Actions\NewOrderAction;
use Domain\Order\Contracts\NewOrderContract;
use Illuminate\Support\ServiceProvider;

class ActionsServiceProvider extends ServiceProvider
{
    public array $bindings = [
        NewOrderContract::class => NewOrderAction::class,
    ];
}
