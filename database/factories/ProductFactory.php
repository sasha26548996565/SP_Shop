<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => ucfirst($this->faker->words(2, true)),
            'thumbnail' => $this->faker->fixturesImage('products', 'images/products'),
            'price' => $this->faker->numberBetween(1000, 100000),
            'brand_id' => Brand::query()->inRandomOrder()->value('id'),
            'on_home_page' => $this->faker->boolean(),
            'sorting' => $this->faker->numberBetween(1, 999),
        ];
    }
}