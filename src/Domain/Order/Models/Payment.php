<?php

declare(strict_types=1);

namespace Domain\Order\Models;

use Illuminate\Database\Eloquent\Model;
use Domain\Order\Payment\Enums\PaymentStates;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'payment_id',
        'payment_gateway',
        'meta',
        'status'
    ];

    protected $casts = [
        'meta' => 'collection'
    ];

    protected $attributes = [
        'state' => PaymentStates::Pending->value
    ];

    public function state(): Attribute
    {
        return Attribute::make(
            get: fn (string $state) => PaymentStates::from($state)->createState($this)
        );
    }

    public function uniqueIds(): array
    {
        return ['payment_id'];
    }
}
