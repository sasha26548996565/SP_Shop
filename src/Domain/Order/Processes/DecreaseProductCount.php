<?php

declare(strict_types=1);

namespace Domain\Order\Processes;

use Closure;
use Domain\Order\Models\Order;
use Domain\Order\Contracts\OrderProcessContract;
use Illuminate\Support\Facades\DB;

final class DecreaseProductCount implements OrderProcessContract
{
    public function handle(Order $order, Closure $next): Order
    {
        cart()->getCartItems()->map(function ($item) {
            $item->offer()->update([
                'quantity' => DB::raw('quantity -' . $item->quantity)
            ]);
        });

        return $next($order);
    }
}
