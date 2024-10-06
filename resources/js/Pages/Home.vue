<template>
    <Head title="- Latest Listings" />

    <div class="mb-4 flex items-center justify-between">
        <div>filters</div>
        <div class="w-1/4">
            <form @submit.prevent="handleSearch">
                <InputField
                    label=""
                    placeholder="Search..."
                    type="search"
                    v-model="form.search"
                >
                    <MagnifyingGlassIcon class="inline-block size-4" />
                </InputField>
            </form>
        </div>
    </div>

    <div v-if="Object.keys(listings.data).length">
        <div class="grid grid-cols-3 gap-4">
            <div v-for="listing in listings.data" :key="listing.id">
                <Card :listing="listing" />
            </div>
        </div>

        <div class="mt-8">
            <PaginationLinks :paginator="listings" />
        </div>
    </div>
    <div v-else>There are no listings</div>
</template>

<script setup>
import Card from '@/Components/Card.vue';
import InputField from '@/Components/InputField.vue';
import PaginationLinks from '@/Components/PaginationLinks.vue';
import { MagnifyingGlassIcon } from '@heroicons/vue/24/outline';
import { router, useForm } from '@inertiajs/vue3';

const props = defineProps({
    listings: Object,
    searchTerm: String,
});

const form = useForm({
    search: props.searchTerm,
});

const handleSearch = () => {
    router.get(route('home'), {
        search: form.search,
    });
};
</script>
