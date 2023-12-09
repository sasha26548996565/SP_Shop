<?php

declare(strict_types=1);

namespace Domain\Order\Processes;

use Closure;
use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\Models\Order;
use Domain\Order\States\PendingOrderState;

final class ChangeStateToPending implements OrderProcessContract
{
    public function handle(Order $order, Closure $next): Order
    {
        $order->status->transitionTo(new PendingOrderState($order));
        return $next($order);
    }
}
