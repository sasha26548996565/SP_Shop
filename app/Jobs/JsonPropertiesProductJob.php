<?php

declare(strict_types=1);

namespace App\Jobs;

use Domain\Product\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class JsonPropertiesProductJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private Product $product
    ) {
    }

    public function handle(): void
    {
        $properties = $this->product->properties->keyValues();
        $this->product->updateQuietly(['json_properties' => $properties]);
    }

    public function uniqueId(): int
    {
        return $this->product->getKey();
    }
}
