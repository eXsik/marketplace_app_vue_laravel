<?php

namespace Tests\Feature;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    public function test_demo_seeding_is_repeatable_without_resetting_existing_passwords(): void
    {
        $this->seed();

        $seller = User::where('email', 'marta@example.test')->firstOrFail();
        $seller->update(['password' => Hash::make('changed-demo-password')]);

        $this->seed();

        $this->assertTrue(Hash::check('changed-demo-password', $seller->fresh()->password));
        $this->assertSame(4, User::whereIn('email', [
            'marta@example.test',
            'jan@example.test',
            'ola@example.test',
            'tomek@example.test',
        ])->count());
        $this->assertSame(12, Listing::count());
    }
}
