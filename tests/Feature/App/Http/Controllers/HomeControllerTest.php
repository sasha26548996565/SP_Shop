<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\HomeController;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_render(): void
    {
        $brand = BrandFactory::new()->createOne([
            'on_home_page' => true,
            'sorting' => 1
        ]);

        $category = CategoryFactory::new()->createOne([
            'on_home_page' => true,
            'sorting' => 1
        ]);

        $product = ProductFactory::new()->createOne([
            'on_home_page' => true,
            'sorting' => 1
        ]);

        BrandFactory::new()
            ->count(5)->create();

        CategoryFactory::new()
            ->count(5)->create();

        ProductFactory::new()
            ->count(5)->create();

        $this->get(action(HomeController::class))
            ->assertOk()
            ->assertViewIs('index')
            ->assertViewHas('brands.0', $brand)
            ->assertViewHas('categories.0', $category)
            ->assertViewHas('products.0', $product);
    }
}
