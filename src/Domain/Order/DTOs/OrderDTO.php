<?php

declare(strict_types=1);

namespace Domain\Order\DTOs;

use Illuminate\Http\Request;
use Support\Traits\Makeable;

final class OrderDTO
{
    use Makeable;

    public function __construct(
        public string $delivery_type_id,
        public string $payment_method_id,
        public ?string $password = null
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return self::make(...$request->only([
            'delivery_type_id',
            'payment_method_id',
            'password',
        ]));
    }
}
