<?php

declare(strict_types=1);

namespace Support\Testing;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;

class FakerImageProvider extends Base
{
    public function fixturesImage(string $fixtureDirectory, string $storageDirectory): string
    {
        $storage = Storage::disk('images');

        if ($storage->exists($storageDirectory) == false) {
            $storage->makeDirectory($storageDirectory);
        }

        $file = $this->generator->file(
            base_path("tests/Fixtures/images/$fixtureDirectory"),
            $storage->path($storageDirectory),
            false
        );

        return '/storage/images/' . trim($storageDirectory, '/') . '/' . $file;
    }
}