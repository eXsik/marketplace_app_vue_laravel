<template>
    <div
        class="flex h-full flex-col justify-between overflow-hidden rounded-lg bg-white shadow-lg dark:bg-slate-800"
    >
        <div>
            <!-- image -->
            <Link href="">
                <img
                    :src="
                        listing.image
                            ? `/storage/${listing.image}`
                            : '/storage/images/listing/default.jpg'
                    "
                    :alt="listing.name + -' image'"
                    class="h-48 w-full bg-slate-300 object-cover object-center"
                />
            </Link>

            <div class="p-4">
                <h3 class="mb-2 text-xl font-semibold">
                    {{ listing.title?.substring(0, 40) }}...
                </h3>

                <p>
                    Listed on
                    {{ new Date(listing.created_at).toLocaleDateString() }} by
                    <button
                        class="text-link"
                        @click="selectUser(listing.user.id)"
                    >
                        {{ listing.user.name }}
                    </button>
                </p>
            </div>
        </div>

        <div v-if="listing.tags" class="flex items-center gap-3 px-4 pb-4">
            <div v-for="tag in listing.tags.split(',')" :key="tag">
                <button
                    @click="selectTag(tag)"
                    class="rounded-md bg-slate-500 px-2 py-px text-white hover:bg-slate-700 dark:hover:bg-slate-900"
                >
                    {{ tag }}
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';

defineProps({
    listing: Object,
});

const params = route().params;

const selectUser = (id) => {
    router.get(
        route('home', {
            user_id: id,
            search: params.search,
            tag: params.tag,
        }),
    );
};

const selectTag = (tag) => {
    router.get(
        route('home', {
            user_id: params.user_id,
            search: params.search,
            tag: tag,
        }),
    );
};
</script>
