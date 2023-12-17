<?php

declare(strict_types=1);

namespace Domain\Wishlist\Models;

use Domain\Auth\Models\User;
use Domain\Product\Models\Offer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'storage_id',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function offers(): BelongsToMany
    {
        return $this->belongsToMany(Offer::class, 'wishlist_offer', 'wishlist_id', 'offer_id');
    }
}
