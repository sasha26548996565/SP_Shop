<?php

declare(strict_types=1);

namespace Domain\Order\Payment\State;

use InvalidArgumentException;
use Domain\Order\Models\Payment;

abstract class PaymentState
{
    protected array $allowedTransitionTo = [];

    public function __construct(protected Payment $payment)
    {
    }

    abstract public function getState(): string;

    abstract public function canBeChange(): bool;

    public function transitionTo(PaymentState $paymentState): void
    {
        if ($this->canBeChange() == false) {
            throw new InvalidArgumentException('State cant be change');
        }

        if (in_array(get_class($paymentState), $this->allowedTransitionTo) == false) {
            throw new InvalidArgumentException('State ' . get_class($paymentState) . ' cant be change');
        }

        $this->payment->updateQuietly([
            'state' => $paymentState->getState()
        ]);
    }
}
