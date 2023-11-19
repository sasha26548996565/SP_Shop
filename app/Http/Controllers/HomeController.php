<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Domain\Catalog\ViewModels\BrandViewModel;
use Domain\Catalog\ViewModels\CategoryViewModel;
use Domain\Product\ViewModels\ProductViewModel;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $brands = BrandViewModel::make()
            ->homePage();
        $categories = CategoryViewModel::make()
            ->homePage();
        $products = ProductViewModel::make()
            ->homePage();

        return view('index', compact(
            'brands',
            'categories',
            'products',
        ));
    }
}
