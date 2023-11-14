<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;
use Database\Factories\ProductFactory;
use Illuminate\Support\Facades\Storage;

class ThumbnailControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_example(): void
    {
        $size = '500x500';
        $method = 'resize';
        $storage = Storage::disk('images');

        config()->set('thumbnail', [
            'allowed_sizes' => [
                $size
            ]
        ]);

        $product = ProductFactory::new()->create();
        $response = $this->get($product->makeThumbnail($size, $method));

        $response->assertOk();
        $storage->assertExists(
            "products/$method/$size/" . File::basename($product->thumbnail)
        );
    }
}
