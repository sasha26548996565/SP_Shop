<?php

declare(strict_types=1);

namespace Domain\Catalog\Sorters;

use Illuminate\Database\Eloquent\Builder;

final class Sorter
{
    public const SORT_KEY = 'sort';

    public function __construct(
        private array $sortColumns
    )
    {}

    public function apply(Builder $query): Builder
    {
        $column = $this->getSortColumn();
        
        return $query->when($column->contains($this->getSortColumns()), function (Builder $q) use ($column) {
            $direction = $column->contains('-') ? 'DESC' : 'ASC';
            $q->orderBy((string) $column->remove('-'), $direction);
        });
    }

    public function getSortKey(): string
    {
        return self::SORT_KEY;
    }

    public function getSortColumn()
    {
        return request()->str($this->getSortKey());
    }

    public function getSortColumns(): array
    {
        return $this->sortColumns;
    }

    public function isActive(string $column, string $direction = 'ASC'): bool
    {
        $column = trim($column, '-');

        if(strtolower($direction) === 'DESC') {
            $column = '-'.$column;
        }

        return request($this->getSortKey()) === $column;
    }
}
