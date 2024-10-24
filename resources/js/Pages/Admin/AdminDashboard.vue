<template>
    <Head title="- Admin" />
    <SessionMessages :status="status" class="my-4 shadow" />

    <!-- Heading -->
    <div class="mb-4 flex items-end justify-between">
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
        </div>
    </div>
    <!-- Table -->
    <table
        class="w-full overflow-hidden rounded-lg border-0 bg-white shadow-md dark:bg-slate-800"
    >
        <thead>
            <tr class="bg-slate-600 text-left text-xs uppercase text-slate-100">
                <th class="w-3/6 p-3">Name</th>
                <th class="w-2/6 p-3">Role</th>
                <th class="w-1/6 p-3">Listings</th>
                <th class="w-1/6 p-3 text-right">View</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-dashed divide-slate-300">
            <tr v-for="(user, index) in users.data" :key="index">
                <td class="w-3/6 px-3 py-5">
                    <p class="mb-1 font-bold">{{ user.name }}</p>
                    <p class="font-ligt text-xs">{{ user.email }}</p>
                </td>
                <td class="w-2/6 px-3 py-5">
                    <RoleSelect :user="user" />
                </td>
                <td class="w-1/6 px-3 py-5">
                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-1">
                            <span>
                                {{
                                    user.listings.filter(
                                        (listing) => listing.approved,
                                    ).length
                                }}
                            </span>
                            <CheckCircleIcon class="size-6 text-green-600" />
                        </div>
                        <div class="flex items-center gap-1">
                            <span>
                                {{
                                    user.listings.filter(
                                        (listing) => !listing.approved,
                                    ).length
                                }}
                            </span>
                            <XCircleIcon class="size-6 text-red-600" />
                        </div>
                    </div>
                </td>
                <td class="w-1/6 px-3 py-5 text-right">View link</td>
            </tr>
        </tbody>
    </table>

    <div class="mt-6">
        <PaginationLinks :paginator="users" />
    </div>
</template>

<script setup>
import InputField from '@/Components/InputField.vue';
import PaginationLinks from '@/Components/PaginationLinks.vue';
import RoleSelect from '@/Components/RoleSelect.vue';
import SessionMessages from '@/Components/SessionMessages.vue';
import {
    CheckCircleIcon,
    MagnifyingGlassIcon,
    XCircleIcon,
} from '@heroicons/vue/24/outline';
import { router, useForm } from '@inertiajs/vue3';

defineProps({
    users: Object,
    status: String,
});

const form = useForm({
    search: '',
});

const handleSearch = () => {
    router.get(
        route('admin.index', {
            search: form.search,
        }),
    );
};
</script>

<style></style>
