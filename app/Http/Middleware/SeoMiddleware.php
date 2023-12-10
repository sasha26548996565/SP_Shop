<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Seo;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class SeoMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $seo = Cache::rememberForever('seo_' . $request->getPathInfo(), function () use ($request) {
            return Seo::where('url', $request->getPathInfo())->first() ?? false;
        });

        if ($seo) {
            View::share('title', $seo->title);
        }

        return $next($request);
    }
}
