<?php

declare(strict_types=1);

namespace Domain\Order\Processes;

use Closure;
use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\DTOs\CustomerDTO;
use Domain\Order\Models\Order;

final class AssignCustomer implements OrderProcessContract
{
    public function __construct(private CustomerDTO $customer)
    {
    }

    public function handle(Order $order, Closure $next): Order
    {
        $order->customer()->create($this->customer->toArray());

        return $next($order);
    }
}
