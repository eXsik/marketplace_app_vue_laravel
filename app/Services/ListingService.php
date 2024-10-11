<?php

namespace App\Services;

use App\Models\Listing;

class ListingService
{
  protected $imageService;

  public function __construct(ImageService $imageService)
  {
    $this->imageService = $imageService;
  }

  public function createListing($user, $fields, $image = null): void
  {
    if ($image) {
      $fields['image'] = $this->imageService->upload($image, 'images/listing');
    }

    $fields['tags'] = Listing::processTags($fields['tags'] ?? []);

    $user->listings()->create($fields);
  }

  public function updateListing(Listing $listing, $fields, $image = null): void
  {
    if ($image) {

      if ($listing->image) {
        $this->imageService->delete($listing->image);
      }

      $fields['image'] = $this->imageService->upload($image, 'images/listing');
    } else {
      $fields['image'] = $listing->image;
    }

    $fields['tags'] = $listing->processTags($fields['tags'] ?? []);

    $listing->update($fields);
  }


  public function deleteListing(Listing $listing): void
  {
    if ($listing->image) {
      $this->imageService->delete($listing->image);
    }

    $listing->delete();
  }
}
