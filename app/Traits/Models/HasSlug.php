<?php

declare(strict_types=1);

namespace App\Traits\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function (Model $item) {
            $slug = Str::slug($item->{self::slugFrom()});
            $countSlug = $item->where('slug', $slug)->count();

            if ($countSlug > 0) {
                $slug .= '-' . ($countSlug + 1);
            }

            $item->slug = $slug;
        });
    }

    public static function slugFrom(): string
    {
        return 'title';
    }
}
