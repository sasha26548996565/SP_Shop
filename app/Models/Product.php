<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\HasThumbnail;
use Domain\Catalog\Models\Category;
use Support\Traits\Models\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Support\Casts\PriceCast;
use Laravel\Scout\Searchable;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Attributes\SearchUsingPrefix;

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
        'brand_id',
        'on_home_page',
        'sorting',
    ];

    protected $casts = [
        'price' => PriceCast::class
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }

    public function scopeHomePage(Builder $query): void
    {
        $query->where('on_home_page', true)
            ->orderBy('sorting')
            ->limit(6);
    }

    public function scopeFiltered(Builder $builder): void
    {
        $builder->when(request('filters.brands'), function (Builder $query) {
            $query->whereIn('brand_id', request('filters.brands'));
        })->when(request('filters.price'), function (Builder $query) {
            $query->whereBetween('price', [
                request('filters.price.from') * 100,
                request('filters.price.to') * 100
            ]);
        });
    }

    public function scopeSorted(Builder $builder): void
    {
        $builder->when(request('sort'), function (Builder $query) {
            $column = request()->str('sort');
            
            if ($column->contains(['title', 'price'])) {
                $direction = $column->contains('-') ? 'DESC' : 'ASC';
                $query->orderBy((string) $column->remove('-'), $direction);
            }
        });
    }

    protected function thumbnailDirectory(): string
    {
        return 'products';
    }

    #[SearchUsingPrefix(['id'])]
    #[SearchUsingFullText(['title', 'text'])]
    public function toSearchableArray(): array
    {
        return [
            'id' => (int) $this->id,
            'title' => $this->title,
            'text' => $this->text,
        ];
    }
}
