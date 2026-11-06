<?php

namespace App\Services;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use RuntimeException;

class ListingService
{
    public function __construct(private readonly ImageService $imageService) {}

    /** @param array<string, mixed> $fields */
    public function createListing(User $user, array $fields, ?UploadedFile $image = null): Listing
    {
        if ($image !== null) {
            $fields['image'] = $this->storeImage($image);
        }

        $fields['tags'] = Listing::processTags($fields['tags'] ?? null);

        return $user->listings()->create($fields);
    }

    /** @param array<string, mixed> $fields */
    public function updateListing(Listing $listing, array $fields, ?UploadedFile $image = null): void
    {
        $previousImage = $listing->image;

        if ($image !== null) {
            $fields['image'] = $this->storeImage($image);
        }

        $fields['tags'] = Listing::processTags($fields['tags'] ?? null);

        try {
            $listing->update([...$fields, 'approved' => false]);
        } catch (\Throwable $exception) {
            if (isset($fields['image']) && $fields['image'] !== $previousImage) {
                $this->imageService->delete($fields['image']);
            }

            throw $exception;
        }

        if ($image !== null && $previousImage !== null) {
            $this->imageService->delete($previousImage);
        }
    }

    public function deleteListing(Listing $listing): void
    {
        if ($listing->image !== null) {
            $this->imageService->delete($listing->image);
        }

        $listing->delete();
    }

    private function storeImage(UploadedFile $image): string
    {
        $path = $this->imageService->upload($image, 'images/listing');

        if ($path === false) {
            throw new RuntimeException('The listing image could not be stored.');
        }

        return $path;
    }
}
