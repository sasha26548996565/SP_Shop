<?php

declare(strict_types=1);

namespace Domain\Catalog\Observers;

use Domain\Catalog\Models\Brand;
use Illuminate\Support\Facades\Cache;

class BrandObserver
{
    public function created(Brand $brand): void
    {
        $this->forgetCache();
    }

    public function updated(Brand $brand): void
    {
        $this->forgetCache();
    }

    public function deleted(Brand $brand): void
    {
        $this->forgetCache();
    }

    private function forgetCache(): void
    {
        Cache::forget('brand_home_page');
    }
}
