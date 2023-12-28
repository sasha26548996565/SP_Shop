<?php

declare(strict_types=1);

namespace Domain\Order\Payment\State;

final class PendingPaymentState extends PaymentState
{
    protected array $allowedTransitionTo = [
        CancelledPaymentState::class,
        PaidPaymentState::class
    ];

    public function getState(): string
    {
        return 'pending';
    }

    public function canBeChange(): bool
    {
        return true;
    }
}
