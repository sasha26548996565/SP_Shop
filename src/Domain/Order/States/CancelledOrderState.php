<?php

declare(strict_types=1);

namespace Domain\Order\States;

class CancelledOrderState extends OrderState
{
    protected array $allowedStatuses = [];

    public function getValue(): string
    {
        return 'cancelled';
    }

    public function getValueForHumans(): string
    {
        return 'Отмененный заказ';
    }

    public function canBeChanged(): bool
    {
        return false;
    }
}
