<?php

declare(strict_types=1);

namespace Domain\Order\States;

class PaidOrderState extends OrderState
{
    protected array $allowedStatuses = [
        CancelledOrderState::class
    ];

    public function getValue(): string
    {
        return 'paid';
    }

    public function getValueForHumans(): string
    {
        return 'Оплачен';
    }

    public function canBeChanged(): bool
    {
        return true;
    }
}
