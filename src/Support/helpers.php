<?php

use Domain\Cart\CartManager;
use Domain\Catalog\Filters\FilterManager;
use Domain\Catalog\Models\Category;
use Domain\Product\Models\Offer;
use Domain\Product\Models\Product;
use Domain\Wishlist\Actions\AddOffer;
use Domain\Wishlist\Contracts\CheckContainOfferContract;
use Support\Flash\Flash;

if (function_exists('flash') == false) {
    function flash(): Flash
    {
        return app(Flash::class);
    }
}

if (function_exists('cart') == false) {
    function cart(): CartManager
    {
        return app(CartManager::class);
    }
}

if (function_exists('filters') == false) {
    function filters(): array
    {
        return app(FilterManager::class)->getFilterItems();
    }
}

if (function_exists('is_catalog_view') == false) {
    function is_catalog_view(string $view, string $default = 'grid'): bool
    {
        return session()->get('view', $default) == $view;
    }
}

if (function_exists('filter_url') == false) {
    function filter_url(?Category $category, array $params = []): string
    {

        return route('catalog', [
            'category' => $category,
            ...request()->only(['filters', 'sort']),
            ...$params
        ]);
    }
}

if (function_exists('check_contain_in_wishlist') == false) {
    function check_contain_in_wishlist(Offer $offer): bool
    {
        $check = app(CheckContainOfferContract::class);
        return $check($offer);
    }
}
