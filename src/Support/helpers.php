<?php

use Domain\Catalog\Filters\FilterManager;
use Support\Flash\Flash;

if (function_exists('filters') == false) {
    function filters(): array
    {
        return app(FilterManager::class)->getFilterItems();
    }
}

if (function_exists('flash') == false) {
    function flash(): Flash
    {
        return app(Flash::class);
    }
}
