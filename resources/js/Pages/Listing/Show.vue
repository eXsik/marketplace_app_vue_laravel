<template>
    <Head title="- Listing Detail" />

    <!-- ADMIN -->

    <div
        v-if="$page.props.auth.user.role === 'admin'"
        class="mb-6 flex items-center justify-between rounded-md bg-white p-6 font-medium dark:bg-slate-800 dark:text-white"
    >
        <p>
            This listing is {{ listing.approved ? 'Approved' : 'Disapproved' }}
        </p>

        <button
            @click.prevent="toggleApprove"
            class="rounded-md bg-slate-600 px-3 py-1 text-white"
        >
            {{ listing.approved ? 'Disapprove it' : 'Approve it' }}
        </button>
    </div>

    <Container class="flex gap-4">
        <div class="w-1/4 overflow-hidden rounded-md">
            <img
                :src="
                    listing.image
                        ? `/storage/${listing.image}`
                        : '/storage/images/listing/default.jpg'
                "
                :alt="listing.title + ' image'"
                class="h-full w-full object-cover object-center"
            />
        </div>

        <div class="w-3/4">
            <div class="mb-6">
                <div class="mb-2 flex items-end justify-between">
                    <p class="w-full border-b pb-2 text-slate-400">
                        Listing detail:
                    </p>

                    <div v-if="canModify" class="flex items-center gap-4 pl-4">
                        <Link
                            :href="route('listing.edit', listing.id)"
                            class="rounded-md bg-green-500 px-6 py-2 text-white outline-offset-2 outline-green-500 hover:outline"
                        >
                            Edit</Link
                        >

                        <button
                            @click="deleteListing"
                            type="button"
                            class="outline-offset-d rounded-md bg-red-500 px-6 py-2 text-white outline-red-500 hover:outline"
                        >
                            Delete
                        </button>
                    </div>
                </div>
                <h3 class="mb-4 text-xl font-bold">{{ listing.title }}</h3>
                <p class="text-slate-700 dark:text-slate-100">
                    {{ listing.description }}
                </p>
            </div>

            <div class="mb-6">
                <p class="mb-2 w-full border-b pb-2 text-slate-400">
                    Contact info:
                </p>

                <div
                    v-if="listing.email"
                    class="mb-2 flex items-center gap-2 text-sm"
                >
                    <AtSymbolIcon class="inline-block size-4 text-slate-800" />
                    <p>Email</p>
                    <a :href="`mailto:${listing.email}`" class="text-link">
                        {{ listing.email }}
                    </a>
                </div>

                <div
                    v-if="listing.link"
                    class="mb-2 flex items-center gap-2 text-sm"
                >
                    <ShareIcon class="inline-block size-4 text-slate-800" />
                    <p>Link</p>
                    <a
                        :href="listing.link"
                        class="text-link"
                        target="_blank"
                        rel="nofollow"
                    >
                        {{ listing.link }}
                    </a>
                </div>
                <div
                    v-if="listing.link"
                    class="mb-2 flex items-center gap-2 text-sm"
                >
                    <UserIcon class="inline-block size-4 text-slate-800" />
                    <p>Listed by:</p>
                    <Link
                        :href="route('home', { user_id: user.id })"
                        class="text-link"
                    >
                        {{ user.name }}
                    </Link>
                </div>
            </div>

            <div v-if="listing.tags" class="mb-6">
                <p class="mb-2 w-full border-b pb-2 text-slate-400">Tags:</p>

                <div class="flex items-center gap-3">
                    <div v-for="tag in listing.tags.split(',')" :key="tag">
                        <Link
                            :href="route('home', { tag })"
                            class="rounded-full bg-slate-500 px-2 py-px text-white transition-colors hover:bg-slate-700 dark:hover:bg-slate-800"
                        >
                            {{ tag }}
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </Container>
</template>

<script setup>
import Container from '@/Components/Container.vue';
import { AtSymbolIcon, ShareIcon, UserIcon } from '@heroicons/vue/24/outline';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
    listing: Object,
    user: Object,
    canModify: Boolean,
});

const deleteListing = () => {
    if (confirm('Are you sure?')) {
        router.delete(route('listing.destroy', props.listing.id));
    }
};

const toggleApprove = () => {
    let msg = props.listing.approved
        ? 'Disapprove this listing?'
        : 'Approve this listing';

    if (confirm(msg)) {
        router.put(route('admin.approve', props.listing.id));
    }
};
</script>
