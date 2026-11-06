<?php

namespace Tests\Feature;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ListingControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_index_returns_listings_page(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Listing::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertInertia(fn($page) => $page->component('Home')
            ->has('listings'));
    }

    public function test_listing_can_be_created_without_tags(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->post(route('listing.store'), [
            'title' => 'Listing without tags',
            'description' => 'Description',
        ])->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('listings', [
            'title' => 'Listing without tags',
            'tags' => '',
        ]);
    }

    public function test_listing_tags_can_be_updated(): void
    {
        $user = User::factory()->create();
        $listing = Listing::factory()->for($user)->create(['tags' => 'old,tag']);
        $this->actingAs($user);

        $this->put(route('listing.update', $listing), [
            'title' => $listing->title,
            'description' => $listing->description,
            'tags' => ' new, updated tag ',
        ])->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('listings', [
            'id' => $listing->id,
            'tags' => 'new,updated tag',
        ]);
    }

    public function test_uploaded_listing_image_is_saved_and_deleted_with_listing(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->post(route('listing.store'), [
            'title' => 'Listing with image',
            'description' => 'Description',
            'image' => UploadedFile::fake()->image('listing.jpg'),
        ])->assertRedirect(route('dashboard'));

        $listing = Listing::where('title', 'Listing with image')->firstOrFail();
        $this->assertNotEmpty($listing->image);
        Storage::disk('public')->assertExists($listing->image);

        $this->delete(route('listing.destroy', $listing))->assertRedirect(route('dashboard'));

        Storage::disk('public')->assertMissing($listing->image);
        $this->assertDatabaseMissing('listings', ['id' => $listing->id]);
    }

    public function test_user_cannot_update_or_delete_another_users_listing(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $listing = Listing::factory()->for($owner)->create();
        $this->actingAs($otherUser);

        $this->put(route('listing.update', $listing), [
            'title' => 'Changed title',
            'description' => 'Changed description',
        ])->assertForbidden();

        $this->delete(route('listing.destroy', $listing))->assertForbidden();

        $this->assertDatabaseHas('listings', [
            'id' => $listing->id,
            'title' => $listing->title,
        ]);
    }
}
