<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ThumbnailController extends Controller
{
    public function __invoke(string $directory, string $method, string $size, string $file): BinaryFileResponse
    {
        abort_if(
            in_array($size, config('thumbnail.allowed_sizes', [])) == false,
            Response::HTTP_FORBIDDEN
        );

        $storage = Storage::disk('images');
        $realPath = "$directory/$file";
        $newDirectoryPath = "$directory/$method/$size";
        $resultPath = "$newDirectoryPath/$file";

        if ($storage->exists($newDirectoryPath) == false) {
            $storage->makeDirectory($newDirectoryPath);
        }

        if ($storage->exists($resultPath) == false) {
            $image = Image::make($storage->path($realPath));
            [$width, $height] = explode('x', $size);
            $image->{$method}($width, $height);
            $image->save($storage->path($resultPath));
        }

        return response()->file($storage->path($resultPath));
    }
}
