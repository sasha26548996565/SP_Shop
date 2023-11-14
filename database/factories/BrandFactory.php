<?php

declare(strict_types=1);

namespace Database\Factories;

use Domain\Catalog\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->company(),
            'thumbnail' => $this->faker->fixturesImage('brands', 'brands'),
            'on_home_page' => $this->faker->boolean(),
            'sorting' => $this->faker->numberBetween(1, 999),
        ];
    }
}