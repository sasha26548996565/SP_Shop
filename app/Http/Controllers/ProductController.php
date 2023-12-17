<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Domain\Product\Models\Offer;
use Domain\Product\Models\Product;
use DomainException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(Product $product): View
    {
        $product->load('optionValues.option');

        $this->addViewed($product->id);
        $viewedProducts = $this->getViewed($product->id);

        $options = $product->optionValues->keyValues();

        $offer = null;
        $optionValueIds = json_encode(request('optionValueIds') ?? []);
        if (request()->has('optionValueIds')) {
            $offer = Offer::where('product_id', $product->id)
                ->whereJsonContains('option_value_ids', json_decode(request('optionValueIds')))->first();

            if (is_null($offer)) {
                throw new DomainException('Данного товара нет в наличии');
            }

            $optionValueIds = request('optionValueIds');
        }

        return view('product.show', compact(
            'product',
            'options',
            'viewedProducts',
            'offer',
            'optionValueIds'
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
