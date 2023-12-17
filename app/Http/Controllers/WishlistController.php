<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Domain\Product\Models\Offer;
use Domain\Wishlist\Contracts\AddOfferContract;
use Domain\Wishlist\Contracts\GetWishlistContract;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class WishlistController extends Controller
{
    public function index(GetWishlistContract $getWishlist): View
    {
        $offers = $getWishlist()->offers()->paginate(12);

        return view('wishlist.index', compact('offers'));
    }

    public function addOffer(Offer $offer, AddOfferContract $addOffer): RedirectResponse
    {
        $addOffer($offer);
        return to_route('wishlist');
    }
}
