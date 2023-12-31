<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\OfferFactory;
use Database\Factories\OptionFactory;
use Database\Factories\OptionValueFactory;
use Database\Factories\ProductFactory;
use Database\Factories\PropertyFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        BrandFactory::new()->count(10)->create();
        $properties = PropertyFactory::new()->count(10)->create();
        OptionFactory::new()->count(2)->create();
        $optionValues = OptionValueFactory::new()->count(10)->create();

        CategoryFactory::new()->count(15)
            ->has(
                ProductFactory::new()
                    ->count(random_int(1, 3))
                    ->hasAttached($optionValues)
                    ->hasAttached($properties, function () {
                        return ['value' => ucfirst(fake()->word())];
                    })->has(OfferFactory::new()->count(random_int(1, 3)))
            )
            ->create();
    }
}
