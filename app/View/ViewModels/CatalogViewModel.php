<?php

namespace App\View\ViewModels;

use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Spatie\ViewModels\ViewModel;

class CatalogViewModel extends ViewModel
{
    public function __construct(
        public Category $category
    ) {
    }

    public function products(): LengthAwarePaginator
    {
        return Product::select(['id', 'title', 'slug', 'thumbnail', 'price', 'json_properties'])
            ->search()
            ->withCategory($this->category)
            ->filtered()
            ->sorted()
            ->paginate(6);
    }

    public function categories(): Collection
    {
        return Category::select(['id', 'title', 'slug'])
            ->has('products')
            ->get();
    }
}
