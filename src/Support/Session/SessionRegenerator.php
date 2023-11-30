<?php

declare(strict_types=1);

namespace Support\Session;

use App\Events\AfterSessionRegistered;
use Closure;

class SessionRegenerator implements SessionRegeneratorContract
{
    public function run(Closure $callback = null): void
    {
        $oldSessionId = request()->session()->getId();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        if ($callback != null) {
            $callback();
        }

        event(new AfterSessionRegistered(
            $oldSessionId,
            request()->session()->getId()
        ));
    }
}
