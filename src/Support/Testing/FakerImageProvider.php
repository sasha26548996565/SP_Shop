<?php

declare(strict_types=1);

namespace Support\Testing;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;

class FakerImageProvider extends Base
{
    public function fixturesImage(string $fixtureDirectory, string $storageDirectory): string
    {
        if (Storage::exists($storageDirectory) == false) {
            Storage::makeDirectory($storageDirectory);
        }

        $file = $this->generator->file(
            base_path("tests/Fixtures/images/$fixtureDirectory"),
            Storage::path($storageDirectory),
            false
        );

        return '/storage/' . trim($storageDirectory, '/') . '/' . $file;
    }
}