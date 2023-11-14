<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\ViewModels\BrandViewModel;
use Domain\Catalog\ViewModels\CategoryViewModel;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $brands = BrandViewModel::make()
            ->homePage();
        $categories = CategoryViewModel::make()
            ->homePage();
        $products = Product::homePage()
            ->get();

        return view('index', compact(
            'brands',
            'categories',
            'products',
        ));
    }
}