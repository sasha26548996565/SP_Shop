<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;
use Domain\Product\Models\Product;
use Domain\Catalog\Models\Category;
use Database\Factories\ProductFactory;
use Database\Factories\CategoryFactory;
use App\Http\Controllers\CatalogController;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CatalogControllerTest extends TestCase
{
    use RefreshDatabase;

    private Product $product;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->product = ProductFactory::new()->createOne();
        $this->category = CategoryFactory::new()->createOne();
    }

    private function getProductByCategories(): Collection
    {
        return $this->product->categories;
    }

    public function test_render_page(): void
    {
        $this->get(action(CatalogController::class))
            ->assertSee($this->product->title)
            ->assertOk();
    }

    public function test_render_page_with_category(): void
    {
        $this->product->categories()->attach($this->category->id);

        $this->get(action(CatalogController::class, $this->category))
            ->assertSee($this->product->title)
            ->assertOk();
    }

    public function test_dont_see_product(): void
    {
        $productCategories = $this->getProductByCategories();

        if ($productCategories->contains($this->category->id)) {
            $productCategories->detach($this->category->id);
        }

        $this->get(action(CatalogController::class, $this->category))
            ->assertDontSee($this->product->title)
            ->assertOk();
    }

    public function test_product_filtered(): void
    {
        $request = [
            'filters' => [
                'price' => [
                    'from' => 100,
                    'to' => 10000
                ]
            ]
        ];

        $productShowed = ProductFactory::new()->createOne([
            'price' => 1000
        ]);

        $this->get(action(CatalogController::class, $request))
            ->assertSeeText($productShowed->title)
            ->assertOk();
    }

    public function test_product_sorted(): void
    {
        $request = [
            'sort' => 'title'
        ];

        $products = ProductFactory::new()->count(3)->create();

        $this->get(action(CatalogController::class, $request))
            ->assertSeeInOrder(
                $products->sortBy('title')
                    ->flatMap(fn($product) => [
                        $product->title
                    ])
                    ->toArray()
            )
            ->assertOk();
    }
}
