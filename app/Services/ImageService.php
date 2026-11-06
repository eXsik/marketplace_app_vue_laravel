<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function upload(UploadedFile $image, string $directory): string|false
    {
        return $image->store($directory, 'public');
    }

    public function delete(string $path): bool
    {
        return Storage::disk('public')->delete($path);
    }
}
