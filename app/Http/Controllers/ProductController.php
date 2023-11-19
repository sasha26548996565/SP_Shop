<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __invoke(Product $product): View
    {
        $product->load('optionValues.option');

        $this->addViewed($product->id);
        $viewedProducts = $this->getViewed($product->id);

        $options = $product->optionValues->keyValues();

        return view('product.show', compact(
            'product',
            'options',
            'viewedProducts'
        ));
    }

    private function addViewed(int $productId): void
    {
        session()->put('also.' . $productId, $productId);
    }

    private function getViewed(int $exceptProductId): Collection
    {
        return Product::whereIn(
            'id',
            collect(session()->get('also'))
                ->except($exceptProductId)
        )->get();
    }
}
