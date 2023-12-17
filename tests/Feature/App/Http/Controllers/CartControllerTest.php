<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\CartController;
use Database\Factories\OfferFactory;
use Database\Factories\OptionFactory;
use Database\Factories\OptionValueFactory;
use Database\Factories\ProductFactory;
use Domain\Cart\CartManager;
use Domain\Product\Models\Offer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    private Offer $offer;

    protected function setUp(): void
    {
        parent::setUp();

        CartManager::fake();

        ProductFactory::new()->create();
        OptionFactory::new()->create();
        OptionValueFactory::new()->create();

        $this->offer = OfferFactory::new()->create();
    }

    private function getOffer(): Offer
    {
        return $this->offer;
    }

    public function test_cart_is_empty(): void
    {
        $this->get(action([CartController::class, 'index']))
            ->assertOk()
            ->assertViewIs('cart.index')
            ->assertViewHas('items', collect([]));
    }

    public function test_cart_is_not_empty(): void
    {
        cart()->addItem($this->getOffer());

        $this->get(action([CartController::class, 'index']))
            ->assertOk()
            ->assertViewIs('cart.index')
            ->assertViewHas('items', cart()->getCartItems());
    }

    public function test_cart_add_item_success(): void
    {
        $productCount = 5;
        $this->assertEquals(0, cart()->getTotalQuantity());

        $this->post(
            action([CartController::class, 'addItem'], $this->getOffer()),
            ['quantity' => $productCount]
        );

        $this->assertEquals($productCount, cart()->getTotalQuantity());
    }
}
