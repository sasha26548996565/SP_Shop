<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $brands = Brand::homePage()
            ->get();
        $categories = Category::homePage()
            ->get();
        $products = Product::homePage()
            ->get();

        return view('index', compact(
            'brands',
            'categories',
            'products',
        ));
    }
}