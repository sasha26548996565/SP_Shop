<?php

declare(strict_types=1);

namespace Tests\Feature\App\Jobs;

use App\Jobs\JsonPropertiesProductJob;
use Database\Factories\ProductFactory;
use Database\Factories\PropertyFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class JsonPropertiesProductJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_set_json_property_successful(): void
    {
        $queue = Queue::getFacadeRoot();
        Queue::fake([JsonPropertiesProductJob::class]);

        $properties = PropertyFactory::new()->count(10)->create();
        $product = ProductFactory::new()
            ->hasAttached($properties, function () {
                return ['value' => fake()->word()];
            })
            ->create();

        $this->assertEmpty($product->json_properties);

        Queue::swap($queue);
        JsonPropertiesProductJob::dispatchSync($product);

        $product->refresh();
        $this->assertNotEmpty($product->json_properties);
    }
}
