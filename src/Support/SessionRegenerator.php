<?php

declare(strict_types=1);

namespace Support;

use App\Events\AfterSessionRegistered;
use Closure;

class SessionRegenerator
{
    public function run(?Closure $callback): void
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
