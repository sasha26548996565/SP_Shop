<?php

use App\Support\Flash\Flash;

if (function_exists('') == false) {
    function flash(): Flash
    {
        return app(Flash::class);
    }
}