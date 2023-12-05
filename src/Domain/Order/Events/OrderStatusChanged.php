<?php

declare(strict_types=1);

namespace Domain\Order\Events;

use Domain\Order\Models\Order;
use Domain\Order\States\OrderState;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly Order $order,
        public readonly OrderState $oldState,
        public readonly OrderState $currentState,
    ) {
    }
}
