<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Brand::factory(10)->create();
        Category::factory(15)
            ->has(Product::factory(random_int(1, 3)))
            ->create();
    }
}
