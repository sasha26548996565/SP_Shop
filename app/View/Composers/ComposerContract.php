<?php

declare(strict_types=1);

namespace App\View\Composers;

use Illuminate\View\View;

interface ComposerContract
{
    public function compose(View $view): void;
}
