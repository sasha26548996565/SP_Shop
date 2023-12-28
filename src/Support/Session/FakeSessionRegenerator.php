<?php

declare(strict_types=1);

namespace Support\Session;

use Domain\Order\Events\AfterSessionRegistered;
use Closure;

class FakeSessionRegenerator implements SessionRegeneratorContract
{
    public function run(Closure $callback = null): void
    {
        event(new AfterSessionRegistered(
            'test',
            'test'
        ));
    }
}
