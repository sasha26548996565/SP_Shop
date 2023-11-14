<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;

class CatalogController extends Controller
{
    public function __invoke(?Category $category): View
    {
        $brands = Brand::select(['id', 'title', 'slug', 'thumbnail'])
            ->has('products')
            ->get();

        $categories = Category::select(['id', 'title', 'slug'])
            ->has('products')
            ->get();

        $products = Product::search(request('search'))
            ->query(function (Builder $builder) use ($category) {
                $builder->select(['id', 'title', 'slug', 'thumbnail', 'price'])
                    ->when($category->exists, function (Builder $query) use ($category) {
                        $query->whereRelation('categories', 'categories.id', '=', $category->id);
                    })
                    ->filtered()
                    ->sorted();
            })
            ->paginate(6);

        return view('catalog.index', compact(
            'brands',
            'categories',
            'products',
            'category'
        ));
    }
}
