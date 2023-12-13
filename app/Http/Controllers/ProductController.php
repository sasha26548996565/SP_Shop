<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Domain\Product\Models\Offer;
use Domain\Product\Models\Product;
use DomainException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(Product $product): View
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

    // compact in 1 method show, (..., array $optionValueIds = null)
    public function showOffer(Product $product, Request $request): View
    {
        $product->load('optionValues.option');

        $this->addViewed($product->id);
        $viewedProducts = $this->getViewed($product->id);

        $options = $product->optionValues->keyValues();

        $offer = Offer::where('product_id', $product->id)
            ->whereJsonContains('option_value_ids', json_decode(request('optionValueIds')))->first();

        if (is_null($offer)) {
            throw new DomainException('Данного товара нет в наличии');
        }

        return view('product.offer', compact(
            'product',
            'options',
            'viewedProducts',
            'offer'
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
