<?php

declare(strict_types=1);

namespace Domain\Product\Collections;

use Illuminate\Database\Eloquent\Collection;

final class OptionValueCollection extends Collection
{
    public function keyValues(): \Illuminate\Support\Collection
    {
        return $this->mapToGroups(function ($optionValue) {
            return [$optionValue->option->title => $optionValue];
        });
    }
}
