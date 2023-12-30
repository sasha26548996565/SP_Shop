<?php

declare(strict_types=1);

namespace Domain\Order\Payment;

use Closure;
use Domain\Order\Exceptions\PaymentProcessException;
use Domain\Order\Exceptions\PaymentProviderException;
use Domain\Order\Models\Payment;
use Domain\Order\Models\PaymentHistory;
use Domain\Order\Payment\Contracts\PaymentGatewayContract;
use Domain\Order\Payment\DTOs\PaymentDTO;
use Domain\Order\Payment\State\PaidPaymentState;
use Domain\Order\Traits\PaymentEvents;
use Exception;

final class PaymentSystem
{
    use PaymentEvents;

    private static PaymentGatewayContract $provider;

    public static function provider(PaymentGatewayContract|Closure $provider): void
    {
        if (is_callable($provider)) {
            $provider = call_user_func($provider);
        }

        if ($provider instanceof PaymentGatewayContract == false) {
            throw PaymentProviderException::notAvailable();
        }
    }

    public static function create(PaymentDTO $paymentDTO): PaymentGatewayContract
    {
        if (self::$provider instanceof PaymentGatewayContract == false) {
            throw PaymentProviderException::notAvailable();
        }

        Payment::query()->create([
            'payment_id' => $paymentDTO->paymentId,
            'payment_gateway' => $paymentDTO->returnUrl,
            'meta' => $paymentDTO->meta,
        ]);

        if (is_callable(self::$onCreating)) {
            $paymentDto = call_user_func(self::$onCreating, $paymentDTO);
        }

        return self::$provider->data($paymentDTO);
    }

    public static function validate(): PaymentGatewayContract
    {
        if (self::$provider instanceof PaymentGatewayContract == false) {
            throw PaymentProviderException::notAvailable();
        }

        PaymentHistory::query()->create([
            'method' => request()->method(),
            'payload' => self::$provider->request(),
            'payment_gateway' => get_class(self::$provider)
        ]);

        if (is_callable(self::$onValidating)) {
            call_user_func(self::$onValidating);
        }

        if (self::$provider->isValidate() && self::$provider->isPaid()) {
            try {
                $payment = Payment::query()
                    ->where('payment_id', self::$provider->paymentId())
                    ->firstOr(function () {
                        throw PaymentProcessException::notFound();
                    });

                if (is_callable(self::$onSuccess)) {
                    call_user_func(self::$onSuccess, $payment);
                }

                $payment->state->transitionTo(new PaidPaymentState($payment));
            } catch (PaymentProcessException $exception) {
                if (is_callable(self::$onError)) {
                    call_user_func(
                        self::$onError,
                        self::$provider->getErrorMessage() ?? $exception->getMessage()
                    );
                }
            }
        }

        return self::$provider;
    }
}
