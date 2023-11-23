<?php

declare(strict_types=1);

namespace Domain\Product\Models;

use Domain\Product\Collections\OptionValueCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OptionValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'option_id'
    ];

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class, 'option_id', 'id');
    }

    public function newCollection(array $models = []): OptionValueCollection
    {
        return new OptionValueCollection($models);
    }
}
