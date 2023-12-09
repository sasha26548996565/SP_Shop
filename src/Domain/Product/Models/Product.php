<?php

declare(strict_types=1);

namespace Domain\Product\Models;

use App\Jobs\JsonPropertiesProductJob;
use Support\Traits\Models\HasThumbnail;
use Carbon\Carbon;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Domain\Product\QueryBuilders\ProductQueryBuilder;
use Support\Traits\Models\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Support\Casts\PriceCast;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;
    use Searchable;

    protected $fillable = [
        'title',
        'slug',
        'text',
        'thumbnail',
        'price',
        'quantity',
        'brand_id',
        'on_home_page',
        'sorting',
        'json_properties',
    ];

    protected $casts = [
        'price' => PriceCast::class,
        'json_properties' => 'array'
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'product_property', 'product_id', 'property_id')
            ->withPivot('value');
    }

    public function optionValues(): BelongsToMany
    {
        return $this->belongsToMany(OptionValue::class, 'option_value_product', 'product_id', 'option_value_id');
    }

    protected static function boot(): void
    {
        parent::boot();

        static::created(function (Product $product) {
            JsonPropertiesProductJob::dispatch($product)
                ->delay(Carbon::now()->addSecond(10));
        });
    }

    public function newEloquentBuilder($query): ProductQueryBuilder
    {
        return new ProductQueryBuilder($query);
    }

    protected function thumbnailDirectory(): string
    {
        return 'products';
    }
}
