<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\ProductController;
use Database\Factories\BrandFactory;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_render_page(): void
    {
        BrandFactory::new()->create();
        $product = ProductFactory::new()->createOne();

        $this->get(action([ProductController::class, 'show'], $product))
            ->assertOk()
            ->assertSee($product->title)
            ->assertSee($product->brand->title);
    }
}
