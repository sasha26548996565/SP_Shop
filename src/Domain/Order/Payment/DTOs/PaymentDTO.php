<?php

declare(strict_types=1);

namespace Domain\Order\Payment\DTOs;

use Support\ValueObjects\Price;
use Illuminate\Support\Collection;

class PaymentDTO
{
    public function __construct(
        public string $paymentId,
        public string $description,
        public string $returnUrl,
        public Price $amount,
        public Collection $meta,
    ) {
    }
}
