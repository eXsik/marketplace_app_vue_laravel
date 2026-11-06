<?php

namespace Tests\Feature;

use App\Models\Listing;
use App\Models\User;
use Tests\TestCase;

class ModelFilterTest extends TestCase
{
    public function test_listing_filters_use_the_passed_values_and_match_tags_exactly(): void
    {
        $seller = User::factory()->create();
        $firstMatch = Listing::factory()->for($seller)->create(['tags' => 'dom,design']);
        $secondMatch = Listing::factory()->for($seller)->create(['tags' => 'rowery,dom']);
        Listing::factory()->for($seller)->create(['tags' => 'domena,design']);
        Listing::factory()->for($seller)->create(['tags' => 'domX,design']);
        Listing::factory()->create(['tags' => 'dom,design']);

        $ids = Listing::query()
            ->filter(['tag' => 'dom', 'user_id' => $seller->id])
            ->pluck('id')
            ->all();

        $this->assertEqualsCanonicalizing([$firstMatch->id, $secondMatch->id], $ids);
    }

    public function test_listing_search_uses_the_passed_filter_value(): void
    {
        $match = Listing::factory()->create(['title' => 'Rare ceramic vase']);
        Listing::factory()->create(['title' => 'Bicycle helmet']);

        $ids = Listing::query()->filter(['search' => 'ceramic'])->pluck('id')->all();

        $this->assertSame([$match->id], $ids);
    }

    public function test_tag_filter_treats_sql_wildcards_as_literal_tag_characters(): void
    {
        $match = Listing::factory()->create(['tags' => 'foo_bar,design']);
        Listing::factory()->create(['tags' => 'fooXbar,design']);

        $ids = Listing::query()->filter(['tag' => 'foo_bar'])->pluck('id')->all();

        $this->assertSame([$match->id], $ids);
    }

    public function test_user_role_filter_uses_the_passed_filter_value(): void
    {
        $suspended = User::factory()->create(['role' => 'suspended']);
        User::factory()->create(['role' => 'general']);

        $ids = User::query()->filter(['user_role' => 'suspended'])->pluck('id')->all();

        $this->assertSame([$suspended->id], $ids);
    }
}
