<?php

declare(strict_types=1);

namespace Domain\Order\Processes;

use Closure;
use Domain\Order\Models\Order;
use Domain\Order\Contracts\OrderProcessContract;

final class ClearCart implements OrderProcessContract
{
    public function handle(Order $order, Closure $next): Order
    {
        cart()->clear();
        return $next($order);
    }
}
