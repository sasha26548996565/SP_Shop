<?php

declare(strict_types=1);

namespace App\Filters;

use Domain\Catalog\Filters\AbstractFilter;
use Domain\Catalog\Models\Brand;
use Illuminate\Database\Eloquent\Builder;

final class BrandFilter extends AbstractFilter
{
    public function __construct()
    {
        $brands = Brand::select(['id', 'title', 'slug', 'thumbnail'])
            ->has('products')
            ->get()
            ->pluck('title', 'id')
            ->toArray();
        parent::__construct(
            'Бренды',
            'brands',
            $brands,
            'catalog.filters.brand'
        );
    }

    public function apply(Builder $query): Builder
    {
        return $query->when($this->getRequestValue(null, null), function (Builder $q) {
            $q->whereIn('brand_id', $this->getRequestValue(null, null));
        });
    }
}
