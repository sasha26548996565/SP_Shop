<?php

declare(strict_types=1);

namespace Support\Traits\Models;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function (Model $item) {
            $item->makeSlug();
        });
    }
    
    protected function makeSlug(): void
    {
        if ($this->{$this->slugColumn()} == false) {
            $slug = $this->makeSlugUnique(
                str($this->{$this->slugFrom()})
                    ->slug()
                    ->value()
            );

            $this->{$this->slugColumn()} = $slug;
        }
    }

    protected static function slugFrom(): string
    {
        return 'title';
    }
    
    protected static function slugColumn(): string
    {
        return 'slug';
    }

    private function makeSlugUnique(string $slug): string
    {
        $originalSlug = $slug;
        $count = 0;

        while ($this->isSlugExists($slug)) {
            $count++;
            $slug = $originalSlug . '-' . $count;
        }

        return $slug;
    }

    private function isSlugExists(string $slug): bool
    {
        $query = $this->newQuery()
            ->where(self::slugColumn(), $slug)
            ->where($this->getKeyName(), '!=', $this->getKey())
            ->withoutGlobalScopes();

        return $query->exists();
    }
}