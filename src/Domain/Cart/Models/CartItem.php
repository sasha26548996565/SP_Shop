<?php

declare(strict_types=1);

namespace Domain\Cart\Models;

use Domain\Product\Models\OptionValue;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Support\Casts\PriceCast;
use Support\ValueObjects\Price;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'quantity',
        'product_id',
        'cart_id',
        'string_option_values'
    ];

    protected $casts = [
        'price' => PriceCast::class
    ];

    public function getTotalPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => Price::make(
                $this->price->getRawValue() * $this->quantity
            )
        );
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class, 'cart_id', 'id');
    }

    public function optionValues(): BelongsToMany
    {
        return $this->belongsToMany(OptionValue::class, 'cart_item_option_value', 'cart_item_id', 'option_value_id');
    }
}
