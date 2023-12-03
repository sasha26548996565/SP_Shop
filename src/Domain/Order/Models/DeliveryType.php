<?php

declare(strict_types=1);

namespace Domain\Order\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Casts\PriceCast;

class DeliveryType extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'with_address'
    ];

    protected $casts = [
        'price' => PriceCast::class
    ];
}
