<?php

declare(strict_types=1);

namespace Domain\Catalog\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

final class BrandQueryBuilder extends Builder
{
    public function homePage(): BrandQueryBuilder
    {
        return $this->select(['id', 'title', 'slug', 'thumbnail'])
            ->where('on_home_page', true)
            ->orderBy('sorting')
            ->limit(6);
    }
}
