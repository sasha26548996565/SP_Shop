<?php

declare(strict_types=1);

namespace Domain\Catalog\Filters;

final class FilterManager
{
    public function __construct(
        private array $filterItems = []
    )
    {}

    public function getFilterItems(): array
    {
        return $this->filterItems;
    }

    public function setFilterItems(array $items): void
    {
        $this->filterItems = $items;
    }
}
