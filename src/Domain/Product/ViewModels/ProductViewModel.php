<?php

declare(strict_types=1);

namespace Domain\Product\ViewModels;

use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

final class ProductViewModel
{
    use Makeable;

    public function homePage(): Collection
    {
        return Cache::rememberForever('product_home_page', function () {
            return Product::homePage()
                ->get();
        });
    }
}
