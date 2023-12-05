<?php

declare(strict_types=1);

namespace Domain\Order\States;

class PendingOrderState extends OrderState
{
    protected array $allowedStatuses = [
        PaidOrderState::class,
        CancelledOrderState::class
    ];

    public function getValue(): string
    {
        return 'pending';
    }

    public function getValueForHumans(): string
    {
        return 'В обработке';
    }

    public function canBeChanged(): bool
    {
        return true;
    }
}
