<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Product;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        BrandFactory::new()->count(10)->create();
        CategoryFactory::new()->count(15)
            ->has(Product::factory(random_int(1, 3)))
            ->create();
    }
}
