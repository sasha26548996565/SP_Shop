<?php

declare(strict_types=1);

namespace Domain\Order\States;


class NewOrderState extends OrderState
{
    protected array $allowedStatuses = [
        PendingOrderState::class,
        PaidOrderState::class,
        CancelledOrderState::class
    ];

    public function getValue(): string
    {
        return 'new';
    }

    public function getValueForHumans(): string
    {
        return 'Новый заказ';
    }

    public function canBeChanged(): bool
    {
        return true;
    }
}
