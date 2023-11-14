<?php

declare(strict_types=1);

namespace App\Menu;

use Support\Traits\Makeable;

final class MenuItem
{
    use Makeable;

    public function __construct(
        private string $link,
        private string $label
    )
    {}

    public function getLink(): string
    {
        return $this->link;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function isActive(): bool
    {
        $path = parse_url($this->getLink(), PHP_URL_PATH) ?? '/';

        if ($path == '/') {
            return request()->path() == $path;
        }

        return request()->fullUrlIs($this->getLink() . '*');
    }
}
