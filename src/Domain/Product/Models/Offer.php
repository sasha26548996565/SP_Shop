<?php

declare(strict_types=1);

namespace Domain\Product\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Casts\PriceCast;
use Support\Traits\Models\HasThumbnail;

class Offer extends Model
{
    use HasFactory;
    use HasThumbnail;

    protected $fillable = [
        'product_id',
        'option_value_ids',
        'price',
        'quantity',
        'image'
    ];

    protected $casts = [
        'price' => PriceCast::class,
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function thumbnailDirectory(): string
    {
        return 'offers';
    }
}
