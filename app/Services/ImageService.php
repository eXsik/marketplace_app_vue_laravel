<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageService
{
  public function upload($image, $directory)
  {
    return Storage::disk('public')->put($directory, $image);
  }

  public function delete($path)
  {
    return Storage::disk('public')->delete($path);
  }
}
