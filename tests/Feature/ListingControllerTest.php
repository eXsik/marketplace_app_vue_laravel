<?php

namespace Tests\Feature;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListingControllerTest extends TestCase
{
    use RefreshDatabase;

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
}
