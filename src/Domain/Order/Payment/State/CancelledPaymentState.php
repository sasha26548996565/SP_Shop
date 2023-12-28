<?php

declare(strict_types=1);

namespace Domain\Order\Payment\State;

final class CancelledPaymentState extends PaymentState
{
    protected array $allowedTransitionTo = [];

    public function getState(): string
    {
        return 'cancelled';
    }

    public function canBeChange(): bool
    {
        return false;
    }
}
