<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Contracts\Routing\Registrar;

interface RouteRegistrarContract
{
    public function map(Registrar $registrar): void;
}