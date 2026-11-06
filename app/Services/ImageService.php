<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageService
{
  public function upload($image, $directory)
  {
    return $image->store($directory, 'public');
  }

  public function delete($path)
  {
    return Storage::disk('public')->delete($path);
  }
}
