<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Domain\Cart\Models\CartItem;
use Domain\Product\Models\Offer;
use Domain\Product\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        return view('cart.index', [
            'items' => cart()->getCartItemsWithoutCache()
        ]);
    }

    public function addItem(Offer $offer): RedirectResponse
    {
        cart()->addItem(
            $offer,
            (int) request('quantity', 1),
            [$offer->option_value_ids]
        );

        flash()->info('Товар добавлен в корзину');

        return to_route('cart');
    }

    public function updateQuantity(CartItem $cartItem): RedirectResponse
    {
        // make request (if quantity < 0 -> exception)
        cart()->updateQuantity(
            $cartItem,
            (int) request('quantity', 1)
        );

        flash()->info('Количество товара изменено');

        return to_route('cart');
    }

    public function removeItem(CartItem $cartItem): RedirectResponse
    {
        cart()->removeCartItem($cartItem);

        flash()->info('Товар удален из корзины');

        return to_route('cart');
    }

    public function clear(): RedirectResponse
    {
        cart()->clear();

        return to_route('cart');
    }
}
