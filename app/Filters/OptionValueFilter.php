<?php

declare(strict_types=1);

namespace App\Filters;

use Domain\Catalog\Filters\AbstractFilter;
use Domain\Product\Models\OptionValue;
use Illuminate\Database\Eloquent\Builder;

class OptionValueFilter extends AbstractFilter
{
    public function __construct()
    {
        $options = OptionValue::all();
        $options->load('option');

        parent::__construct(
            'Опции',
            'optionValueIds',
            $options->keyValues()->toArray(),
            'catalog.filters.option-value'
        );
    }

    public function apply(Builder $query): Builder
    {
        return $query->when($this->getRequestValue(null, null), function (Builder $q) {
            $q->whereHas('optionValues', function (Builder $q) {
                $q->whereIn('option_values.id', array_values($this->getRequestValue(null, null)));
            });
        });
    }
}
