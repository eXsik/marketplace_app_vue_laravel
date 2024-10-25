<template>
    <Head :title="`- ${user.name} Listings`" />

    <SessionMessages :status="status" class="my-4" />
    <!-- Heading -->
    <div class="mb-6">
        <Title>{{ user.name }} latest listings</Title>
        <div class="flex items-end justify-between">
            <div class="flex items-end gap-2">
                <form @submit.prevent="handleSearch">
                    <InputField
                        label=""
                        placeholder="Search..."
                        v-model="form.search"
                    >
                        <MagnifyingGlassIcon class="inline-block size-4" />
                    </InputField>
                </form>
                <Link
                    v-if="params.search"
                    :href="
                        route('admin.index', {
                            ...params,
                            search: null,
                            page: null,
                            user: user.id,
                        })
                    "
                    class="flex items-center gap-2 rounded-md bg-indigo-500 px-2 py-[6px] text-white"
                >
                    {{ params.search }}
                    <XMarkIcon class="inline-block size-4" />
                </Link>
            </div>
            <!-- toggle approve listing btn -->
            <div class="flex items-center gap-2 rounded-md px-2 py-1 text-xs">
                <input
                    @input="handleShowDisapproved"
                    :checked="params.disapproved"
                    type="checkbox"
                    id="showDisapproved"
                    class="border-1 cursor-pointer rounded-md border-slate-700 text-indigo-500 outline-1 ring-indigo-500"
                />
                <label
                    for="showDisapproved"
                    class="cursor-pinter block cursor-pointer text-sm font-medium text-slate-700 dark:text-slate-300"
                >
                    Show disapproved listings
                </label>
            </div>
        </div>
    </div>
    <table
        class="w-full overflow-hidden rounded-lg bg-white ring-1 ring-slate-300 dark:bg-slate-800"
    >
        <thead>
            <tr class="bg-slate-600 text-left text-xs uppercase text-slate-300">
                <th class="w-4/6 p-3">Title</th>
                <th class="w-2/6 p-3 text-center">Approved</th>
                <th class="w-1/6 p-3 text-right">View</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-dashed divide-slate-300">
            <tr v-for="listing in listings.data" :key="listing.id">
                <td class="px-3 py-5">{{ listing.title }}</td>
                <td class="h-full px-3 py-5 text-center text-2xl">
                    <button @click.prevent="toggleApprove(listing)">
                        <template v-if="listing.approved">
                            <CheckCircleIcon
                                class="inline-block size-6 text-green-600"
                            />
                        </template>
                        <template v-else>
                            <XCircleIcon
                                class="inline-block size-6 text-red-600"
                            />
                        </template>
                    </button>
                </td>
                <td class="w-1/6 px-3 py-5 text-right">
                    <Link
                        :href="route('listing.show', listing.id)"
                        class="px-3 text-indigo-400"
                    >
                        <ArrowTopRightOnSquareIcon class="size-5" />
                    </Link>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="mt-6">
        <PaginationLinks :paginator="listings" />
    </div>
</template>

<script setup lang="ts">
import InputField from '@/Components/InputField.vue';
import PaginationLinks from '@/Components/PaginationLinks.vue';
import SessionMessages from '@/Components/SessionMessages.vue';
import Title from '@/Components/Title.vue';
import {
    ArrowTopRightOnSquareIcon,
    CheckCircleIcon,
    MagnifyingGlassIcon,
    XCircleIcon,
    XMarkIcon,
} from '@heroicons/vue/24/outline';
import { router, useForm } from '@inertiajs/vue3';

const props = defineProps({
    user: Object,
    listings: Object,
    status: String,
});

const params = route().params;
const form = useForm({ search: params.search });

const handleSearch = () => {
    router.get(
        route('user.show', {
            user: props.user.id,
            search: form.search,
            disapproved: params.disapproved,
        }),
    );
};

const handleShowDisapproved = (event) => {
    if (event.target.checked) {
        router.get(
            route('user.show', {
                user: props.user.id,
                search: params.search,
                disapproved: true,
            }),
        );
    } else {
        router.get(
            route('user.show', {
                user: props.user.id,
                search: params.search,
                disapproved: null,
            }),
        );
    }
};

const toggleApprove = (listing) => {
    let msg = listing.approved
        ? 'Disapprove this listing?'
        : 'Approve this listing';

    if (confirm(msg)) {
        router.put(route('admin.approve', listing.id));
    }
};
</script>
