<?php

declare(strict_types=1);

namespace Domain\Order\Payment\Enums;

use Domain\Order\Models\Payment;
use Domain\Order\Payment\State\PaymentState;
use Domain\Order\Payment\State\PaidPaymentState;
use Domain\Order\Payment\State\PendingPaymentState;
use Domain\Order\Payment\State\CancelledPaymentState;

enum PaymentStates: string
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Cancelled = 'cancelled';

    public function createState(Payment $payment): PaymentState
    {
        return match ($this) {
            PaymentStates::Pending => new PendingPaymentState($payment),
            PaymentStates::Paid => new PaidPaymentState($payment),
            PaymentStates::Cancelled => new CancelledPaymentState($payment),
        };
    }
}
