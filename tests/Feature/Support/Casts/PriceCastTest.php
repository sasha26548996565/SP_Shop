<?php

declare(strict_types=1);

namespace Tests\Feature\Support\Casts;

use App\Models\Product;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Support\ValueObjects\Price;
use Tests\TestCase;

class PriceCastTest extends TestCase
{
    use RefreshDatabase;

    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();
        $this->product = ProductFactory::new()->create([
            'price' => 10000
        ]);
    }

    public function test_price_cast(): void
    {
        $this->assertDatabaseHas('products', [
            'id' => $this->product->id
        ]);

        $this->assertEquals($this->product->price, Price::make(10000));
    }
}
