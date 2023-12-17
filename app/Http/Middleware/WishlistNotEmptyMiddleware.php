<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Domain\Wishlist\Contracts\GetWishlistContract;
use DomainException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WishlistNotEmptyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $getWishlists = app(GetWishlistContract::class);

        if ($getWishlists()?->offers() == null) {
            throw new DomainException('У вас нет избранных товаров');
        }

        if ($getWishlists()->offers()->count() <= 0) {
            throw new DomainException('У вас нет избранных товаров');
        }

        return $next($request);
    }
}
