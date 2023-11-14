<?php

declare(strict_types=1);

namespace App\Providers;

use App\View\Composers\MenuComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Vite::macro('image', fn (string $asset) => $this->asset("resources/images/$asset"));

        View::composer('shared.menu', MenuComposer::class);
    }
}