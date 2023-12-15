<?php

declare(strict_types=1);

namespace Domain\Order\Processes;

use Closure;
use Domain\Cart\Models\CartItem;
use Domain\Order\Models\Order;
use Domain\Order\Contracts\OrderProcessContract;

final class AssignProducts implements OrderProcessContract
{
    public function handle(Order $order, Closure $next): Order
    {
        $order->items()->createMany(
            cart()->getCartItems()->map(function (CartItem $item) {
                return [
                    'offer_id' => $item->offer_id,
                    'price' => $item->price->getRawValue(),
                    'quantity' => $item->quantity
                ];
            })->toArray(),
        );

        return $next($order);
    }
}
