<?php

declare(strict_types=1);

namespace Domain\Order\Processes;

use Closure;
use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\Models\Order;
use DomainException;

final class CheckProductCount implements OrderProcessContract
{
    public function handle(Order $order, Closure $next): Order
    {
        foreach (cart()->getCartItems() as $item) {
            if ($item->product->quantity < $item->quantity) {
                throw new DomainException('Товар ' . $item->product->title . ', в количестве ' . $item->quantity . ' недоступен!');
            }
        }

        return $next($order);
    }
}
