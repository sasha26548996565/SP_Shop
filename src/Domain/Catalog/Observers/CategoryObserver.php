<?php

declare(strict_types=1);

namespace Domain\Catalog\Observers;

use Domain\Catalog\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryObserver
{
    public function created(Category $brand): void
    {
        $this->forgetCache();
    }

    public function updated(Category $brand): void
    {
        $this->forgetCache();
    }

    public function deleted(Category $brand): void
    {
        $this->forgetCache();
    }

    private function forgetCache(): void
    {
        Cache::forget('category_home_page');
    }
}
