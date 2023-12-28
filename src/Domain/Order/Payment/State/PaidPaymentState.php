<?php

declare(strict_types=1);

namespace Domain\Order\Payment\State;

final class PaidPaymentState extends PaymentState
{
    protected array $allowedTranstionTo = [
        CancelledPaymentState::class,
    ];

    public function getState(): string
    {
        return 'paid';
    }

    public function canBeChange(): bool
    {
        return true;
    }
}
