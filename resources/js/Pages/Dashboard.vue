<template>
    <Head title="- Dashboard" />
    <SessionMessages :status="status" class="my-4" />

    <div v-if="listings">
        <div v-if="Object.keys(listings.data).length">
            <div class="mb-6">
                <!-- heading -->
                <div class="mb-4 flex items-center justify-between">
                    <Title>Your latest listings</Title>
                    <div class="flex items-center gap-4 text-xs">
                        <p class="flex items-center gap-2">
                            Approved
                            <CheckCircleIcon class="size-6 text-green-600" />
                        </p>
                        <p class="flex items-center gap-2">
                            Pending approval
                            <XCircleIcon class="size-6 text-red-600" />
                        </p>
                    </div>
                </div>

                <!-- Table -->
                <table
                    class="w-full table-fixed border-collapse overflow-hidden rounded-md bg-white text-sm shadow-lg ring-1 ring-slate-300 dark:ring-slate-600"
                >
                    <thead
                        class="bg-slate-300 text-xs uppercase text-slate-600 dark:bg-slate-900 dark:text-slate-400"
                    >
                        <tr>
                            <th class="w-3/4 p-3 text-left">Listing Title</th>
                            <th class="w-1/4 py-3 pr-3 text-right">View</th>
                            <th class="w-1/5 py-3 pr-3 text-right">Edit</th>
                            <th class="w-1/5 py-3 pr-3 text-right">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="listing in listings.data"
                            :key="listing.id"
                            class="border-b border-slate-200 hover:bg-slate-100 dark:border-slate-600 dark:bg-slate-800 dark:hover:bg-slate-600"
                        >
                            <td class="w-3/4 p-3 text-left">
                                <div class="flex items-center gap-2">
                                    <img
                                        :src="
                                            listing.image
                                                ? `/storage/${listing.image}`
                                                : '/storage/images/listing/default.jpg'
                                        "
                                        alt=""
                                        class="size-12 object-cover object-center"
                                    />
                                    <h4
                                        class="flex items-center gap-3 font-bold"
                                    >
                                        <template v-if="listing.approved">
                                            <CheckCircleIcon
                                                class="size-6 min-w-6 text-green-600"
                                            />
                                        </template>
                                        <template v-else>
                                            <XCircleIcon
                                                class="size-6 min-w-6 text-red-600"
                                            />
                                        </template>
                                        {{ listing.title }}
                                    </h4>
                                </div>
                            </td>
                            <td
                                class="w-1/4 py-3 pr-3 text-right text-indigo-500"
                            >
                                <Link
                                    v-if="listing.approved"
                                    :href="route('listing.show', listing.id)"
                                >
                                    View
                                </Link>
                            </td>
                            <td
                                class="w-1/5 py-3 pr-3 text-right text-indigo-500"
                            >
                                <Link :href="route('listing.edit', listing.id)">
                                    Edit
                                </Link>
                            </td>
                            <td class="w-1/5 py-3 pr-3 text-right text-red-500">
                                <button
                                    type="button"
                                    @click="deleteListing(listing.id)"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div>
                <PaginationLinks :paginator="listings" />
            </div>
        </div>
        <div v-else>You have no listings!</div>
    </div>
    <p v-else>
        Due to violation of our terms your account has been suspended, please
        contact us at <span class="text-link">email@admin.com</span>
    </p>
</template>

<script setup>
import PaginationLinks from '@/Components/PaginationLinks.vue';
import SessionMessages from '@/Components/SessionMessages.vue';
import Title from '@/Components/Title.vue';
import { CheckCircleIcon, XCircleIcon } from '@heroicons/vue/24/outline';
import { router } from '@inertiajs/vue3';
defineProps({
    listings: Object,
    status: String,
});

const deleteListing = (id) => {
    if (confirm('Are you sure?')) {
        router.delete(route('listing.destroy', id));
    }
};
</script>
