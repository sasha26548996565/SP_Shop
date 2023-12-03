<?php

declare(strict_types=1);

namespace Support\Session;

use Closure;

interface SessionRegeneratorContract
{
    public function run(Closure $callback = null): void;
}
