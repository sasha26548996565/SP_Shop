<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\SeoUrlCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Seo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'url',
    ];

    protected $casts = [
        'url' => SeoUrlCast::class
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::created(function (Seo $seo) {
            Cache::forget('seo_' . $seo->url);
        });

        static::updated(function (Seo $seo) {
            Cache::forget('seo_' . $seo->url);
        });

        static::deleted(function (Seo $seo) {
            Cache::forget('seo_' . $seo->url);
        });
    }
}
