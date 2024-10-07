<template>
    <Head title="- Latest Listings" />

    <div class="mb-4 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <Link
                v-if="params.tag"
                :href="route('home', { ...params, tag: null, page: null })"
                class="flex items-center gap-2 rounded-md bg-indigo-500 px-2 py-1 text-white"
            >
                {{ params.tag }}
                <XMarkIcon class="inline-block size-4" />
            </Link>

            <Link
                v-if="params.search"
                :href="route('home', { ...params, search: null, page: null })"
                class="flex items-center gap-2 rounded-md bg-indigo-500 px-2 py-1 text-white"
            >
                {{ params.search }}
                <XMarkIcon class="inline-block size-4" />
            </Link>

            <Link
                v-if="params.user_id"
                :href="route('home', { ...params, user_id: null, page: null })"
                class="flex items-center gap-2 rounded-md bg-indigo-500 px-2 py-1 text-white"
            >
                {{ username }}
                <XMarkIcon class="inline-block size-4" />
            </Link>
        </div>
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
import { MagnifyingGlassIcon, XMarkIcon } from '@heroicons/vue/24/outline';
import { router, useForm } from '@inertiajs/vue3';

const params = route().params;

const props = defineProps({
    listings: Object,
    searchTerm: String,
});

const form = useForm({
    search: props.searchTerm,
});

const username = params.user_id
    ? props.listings.data.find(
          (item) => item.user_id === Number(params.user_id),
      ).user.name
    : null;

const handleSearch = () => {
    router.get(route('home'), {
        search: form.search,
        user_id: params.user_id,
        tag: params.tag,
    });
};
</script>
