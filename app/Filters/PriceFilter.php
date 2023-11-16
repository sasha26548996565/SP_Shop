<?php

declare(strict_types=1);

namespace App\Filters;

use Domain\Catalog\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class PriceFilter extends AbstractFilter
{
    public function __construct()
    {
        parent::__construct(
            'Цена',
            'price',
            [
                'from' => 0,
                'to' => 100000
            ],
            'catalog.filters.price'
        );
    }

    public function apply(Builder $query): Builder
    {
        return $query->when($this->getRequestValue(null, null), function (Builder $q) {
            $q->whereBetween('price', [
                $this->getRequestValue('from', 0) * 100,
                $this->getRequestValue('to', 100000) * 100
            ]);
        });
    }
}
