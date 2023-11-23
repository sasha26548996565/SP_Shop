<?php

declare(strict_types=1);

namespace Database\Factories;

use Domain\Product\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        return [
            'title' => ucfirst($this->faker->word())
        ];
    }
}
