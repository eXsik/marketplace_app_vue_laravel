<?php

namespace Tests\Feature;

use App\Models\Listing;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class AdminSecurityTest extends TestCase
{
    public function test_admin_dashboard_receives_counts_without_loading_listing_collections(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $seller = User::factory()->create();
        Listing::factory()->for($seller)->create(['approved' => true]);
        Listing::factory()->for($seller)->create(['approved' => false]);

        $this->actingAs($admin)
            ->get(route('admin.index'))
            ->assertInertia(fn (Assert $page) => $page
                ->component('Admin/AdminDashboard')
                ->where('users.data.1.approved_listings_count', 1)
                ->where('users.data.1.disapproved_listings_count', 1)
                ->missing('users.data.1.listings'));
    }

    public function test_non_admin_cannot_change_roles_or_approve_listings(): void
    {
        $member = User::factory()->create();
        $target = User::factory()->create();
        $listing = Listing::factory()->for($target)->create(['approved' => false]);

        $this->actingAs($member)
            ->put(route('admin.role', $target), ['role' => 'admin'])
            ->assertRedirect(route('home'));

        $this->put(route('admin.approve', $listing))->assertRedirect(route('home'));

        $this->assertDatabaseHas('users', ['id' => $target->id, 'role' => 'general']);
        $this->assertDatabaseHas('listings', ['id' => $listing->id, 'approved' => false]);
    }

    public function test_admin_cannot_assign_an_unknown_role(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $target = User::factory()->create();

        $this->actingAs($admin)
            ->from(route('admin.index'))
            ->put(route('admin.role', $target), ['role' => 'root'])
            ->assertSessionHasErrors('role');

        $this->assertDatabaseHas('users', ['id' => $target->id, 'role' => 'general']);
    }

    public function test_registration_rejects_passwords_shorter_than_eight_characters(): void
    {
        $this->from(route('register'))
            ->post('/register', [
                'name' => 'New member',
                'email' => 'new-member@example.test',
                'password' => 'short',
                'password_confirmation' => 'short',
            ])
            ->assertSessionHasErrors('password');

        $this->assertDatabaseMissing('users', ['email' => 'new-member@example.test']);
    }

    public function test_password_update_rejects_passwords_shorter_than_eight_characters(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->from(route('profile.edit'))
            ->put(route('profile.password'), [
                'current_password' => 'password',
                'password' => 'short',
                'password_confirmation' => 'short',
            ])
            ->assertSessionHasErrors('password');
    }
}
