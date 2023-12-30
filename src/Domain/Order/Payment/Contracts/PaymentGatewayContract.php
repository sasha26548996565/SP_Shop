<?php

declare(strict_types=1);

namespace Domain\Order\Payment\Contracts;

use Domain\Order\Payment\DTOs\PaymentDTO;
use Illuminate\Http\JsonResponse;

interface PaymentGatewayContract
{
    public function paymentId(): string;

    public function configure(array $data): void;

    public function data(PaymentDTO $data): self;

    public function request(): mixed;

    public function response(): JsonResponse;

    public function url(): string;

    public function isValidate(): bool;

    public function isPaid(): bool;

    public function getErrorMessage(): string;
}
