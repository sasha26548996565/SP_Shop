<?php

namespace Domain\Order\Providers;

use Domain\Order\Models\Payment;
use Domain\Order\Payment\DTOs\PaymentDTO;
use Domain\Order\Payment\PaymentSystem;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        PaymentSystem::onCreating(function (PaymentDTO $paymentDTO) {
            return $paymentDTO;
        });

        PaymentSystem::onSuccess(function (Payment $Payment) {
        });

        PaymentSystem::onError(function (string $message, Payment $payment) {
        });
    }
}
