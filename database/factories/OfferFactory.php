<?php

declare(strict_types=1);

namespace Database\Factories;

use Domain\Product\Models\Offer;
use Domain\Product\Models\OptionValue;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfferFactory extends Factory
{
    protected $model = Offer::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::query()->inRandomOrder()->value('id'),
            'option_value_ids' => json_decode((string) OptionValue::query()->inRandomOrder()->value('id')),
            'price' => $this->faker->numberBetween(1000, 100000),
            'quantity' => $this->faker->numberBetween(1, 20),
            'thumbnail' => $this->faker->fixturesImage('offers', 'offers')
        ];
    }
}
