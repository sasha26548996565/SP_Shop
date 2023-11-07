<?php

use Support\Flash\Flash;

if (function_exists('flash') == false) {
    function flash(): Flash
    {
        return app(Flash::class);
    }
}