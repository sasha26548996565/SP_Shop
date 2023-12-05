<?php

declare(strict_types=1);

namespace Domain\Order\States;

use Domain\Order\Events\OrderStatusChanged;
use Domain\Order\Models\Order;
use InvalidArgumentException;

abstract class OrderState
{
    protected array $allowedStatuses = [];

    public function __construct(protected Order $order)
    {
    }

    abstract public function getValue(): string;
    abstract public function getValueForHumans(): string;

    abstract public function canBeChanged(): bool;

    public function transitionTo(OrderState $orderState): void
    {
        if ($this->canBeChanged() == false) {
            throw new InvalidArgumentException(
                'Status cant change'
            );
        }

        if (in_array(get_class($orderState), $this->allowedStatuses) == false) {
            throw new InvalidArgumentException(
                "Status '{$orderState->getValue()}' not allowed"
            );
        }

        $this->order->updateQuietly([
            'status' => $orderState->getValue()
        ]);

        event(new OrderStatusChanged(
            $this->order,
            $this->order->status,
            $orderState
        ));
    }
}
