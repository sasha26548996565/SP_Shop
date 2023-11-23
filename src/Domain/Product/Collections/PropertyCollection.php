<?php

declare(strict_types=1);

namespace Domain\Product\Collections;

use Illuminate\Database\Eloquent\Collection;

final class PropertyCollection extends Collection
{
    public function keyValues(): \Illuminate\Support\Collection
    {
        return $this->mapWithKeys(
            fn ($property) => [
                $property->title => $property->pivot->value
            ]
        );
    }
}
