<?php

declare(strict_types=1);

namespace Domain\Cart;

use Domain\Cart\Contracts\CartIdentityStorageContract;
use Domain\Cart\Models\Cart;
use Domain\Cart\Models\CartItem;
use Domain\Cart\StorageIdenties\FakeIdentityStorage;
use Domain\Product\Models\Offer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Support\ValueObjects\Price;

class CartManager
{
    public function __construct(
        private CartIdentityStorageContract $identityStorage
    ) {
    }

    public static function fake(): void
    {
        app()->bind(CartIdentityStorageContract::class, FakeIdentityStorage::class);
    }

    public function updateIdentityStorage(string $oldId, string $currentId): void
    {
        Cart::where('storage_id', $oldId)
            ->update($this->generateCartParams($currentId));
    }

    public function addItem(Offer $offer, int $quantity = 1, array $optionValues = []): Cart
    {
        $cart = Cart::updateOrCreate([
            'storage_id' => $this->identityStorage->getId()
        ], $this->generateCartParams($this->identityStorage->getId()));

        $cartItems = $this->setCartItems($cart, $offer, $quantity, $optionValues);
        //@TODO check type cartItems and decomposite sync option values
        $cartItems->optionValues()->sync($optionValues);
        $this->forgetCache();

        return $cart;
    }

    private function setCartItems(Cart $cart, Offer $offer, int $quantity, array $optionValues) //type hint
    {
        return $cart->cartItems()->updateOrCreate([
            'string_option_values' => $this->convertOptionValuesToString($optionValues),
            'offer_id' => $offer->id
        ], [
            'string_option_values' => $this->convertOptionValuesToString($optionValues),
            'price' => $offer->price,
            'quantity' => DB::raw("quantity + $quantity")
        ]);
    }

    private function convertOptionValuesToString(array $optionValues = []): string
    {
        return implode(';', $optionValues);
    }

    private function generateCartParams(string $storageId): array
    {
        $params = [
            'storage_id' => $storageId
        ];

        if (auth()->check()) {
            $params['user_id'] = auth()->user()->id;
        }

        return $params;
    }

    public function updateQuantity(CartItem $cartItem, int $quantity): void
    {
        $cartItem->update([
            'quantity' => $quantity
        ]);

        $this->forgetCache();
    }

    public function removeCartItem(CartItem $cartItem): void
    {
        $cartItem->delete();
        $this->forgetCache();
    }

    public function clear(): void
    {
        if ($this->getCart()) {
            $this->getCart()->delete();
        }

        $this->forgetCache();
    }

    private function getCart(): mixed
    {
        return Cache::remember($this->getCacheKey(), now()->addHour(), function () {
            return Cart::with('cartItems')
                ->where('storage_id', $this->identityStorage->getId())
                ->when(auth()->check(), function (Builder $query) {
                    $query->orWhere('user_id', auth()->id());
                })->first() ?? false;
        });
    }

    public function getCartItemsWithoutCache(): Collection
    {
        if ($this->getCart() == null) {
            return collect([]);
        }

        return CartItem::select(['id', 'price', 'quantity', 'offer_id', 'cart_id', 'string_option_values'])
            ->with(['offer', 'cart', 'optionValues.option'])
            ->whereBelongsTo($this->getCart())
            ->get();
    }

    public function getCartItems(): Collection
    {
        return $this->getCart()?->cartItems ?? collect([]);
    }

    public function getTotalQuantity(): int
    {
        return $this->getCartItems()->sum('quantity');
    }

    public function getTotalPrice(): Price
    {
        return Price::make(
            $this->getCartItems()->sum(function ($cartItem) {
                return $cartItem->price->getRawValue() * $cartItem->quantity;
            })
        );
    }

    public function getRawTotalPrice(): int
    {
        return $this->getCartItems()->sum(function ($cartItem) {
            return $cartItem->price->getRawValue() * $cartItem->quantity;
        });
    }

    private function getCacheKey(): string
    {
        return str('cart_' . $this->identityStorage->getId())
            ->slug('_')
            ->value();
    }

    private function forgetCache(): void
    {
        //event on forget cache (event name example: CartCleared)
        Cache::forget($this->getCacheKey());
    }
}
