<template>
    <Head title="Administracja" />
    <SessionMessages :status="status" class="mb-6" />

    <!-- Heading -->
    <div
        class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between"
    >
        <div class="flex flex-wrap items-end gap-2">
            <form @submit.prevent="handleSearch">
                <InputField
                    label=""
                    ariaLabel="Szukaj użytkowników"
                    placeholder="Szukaj użytkowników…"
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
                    })
                "
                class="flex items-center gap-2 rounded-md bg-indigo-500 px-2 py-[6px] text-white"
            >
                {{ params.search }}
                <XMarkIcon class="inline-block size-4" />
            </Link>
        </div>

        <!-- toggle role btn -->
        <div class="flex min-h-11 items-center gap-3 rounded-md text-xs">
            <input
                @input="handleToggleRole"
                :checked="params.user_role"
                type="checkbox"
                id="toggleRole"
                class="size-5 cursor-pointer rounded border-slate-400 text-blue-700 focus-visible:ring-2 focus-visible:ring-blue-700"
            />
            <label
                for="toggleRole"
                class="flex min-h-11 cursor-pointer items-center text-sm font-medium text-slate-700"
            >
                Pokaż zawieszonych użytkowników
            </label>
        </div>
    </div>

    <!-- Table -->
    <div
        class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm"
    >
        <table class="w-full min-w-[720px] overflow-hidden border-0 bg-white">
            <thead>
                <tr
                    class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-600"
                >
                    <th class="w-3/6 p-4">Użytkownik</th>
                    <th class="w-2/6 p-4">Rola</th>
                    <th class="w-1/6 p-4">Ogłoszenia</th>
                    <th class="w-1/6 p-4 text-right">Profil</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <tr
                    v-for="user in users.data"
                    :key="user.id"
                    class="border-b border-slate-100 last:border-0"
                >
                    <td class="w-3/6 px-4 py-4">
                        <p class="mb-1 font-bold text-slate-800">
                            {{ user.name }}
                        </p>
                        <p class="text-xs text-slate-500">{{ user.email }}</p>
                    </td>
                    <td class="w-2/6 px-4 py-4">
                        <RoleSelect :user="user" />
                    </td>
                    <td class="w-1/6 px-4 py-4">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-1">
                                <span>
                                    {{ user.approved_listings_count }}
                                </span>
                                <CheckCircleIcon
                                    class="size-5 text-green-600"
                                />
                            </div>
                            <div class="flex items-center gap-1">
                                <span>
                                    {{ user.disapproved_listings_count }}
                                </span>
                                <XCircleIcon class="size-5 text-red-600" />
                            </div>
                        </div>
                    </td>
                    <td class="w-1/6 px-4 py-4 text-right">
                        <Link
                            :href="route('user.show', user.id)"
                            :aria-label="`Otwórz konto użytkownika ${user.name}`"
                            class="inline-flex min-h-11 min-w-11 items-center justify-center rounded-lg text-blue-800 hover:bg-blue-50"
                        >
                            <ArrowTopRightOnSquareIcon class="size-5" />
                        </Link>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div v-if="!users.data.length" class="empty-state mt-5">
        <h2>Nie znaleziono użytkowników</h2>
        <p>Zmień kryteria wyszukiwania lub wyłącz filtr zawieszonych kont.</p>
    </div>

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
    ArrowTopRightOnSquareIcon,
    CheckCircleIcon,
    MagnifyingGlassIcon,
    XCircleIcon,
    XMarkIcon,
} from '@heroicons/vue/24/outline';
import { router, useForm } from '@inertiajs/vue3';

defineProps({
    users: Object,
    status: String,
});

const params = route().params;

const form = useForm({
    search: params.search,
});

const handleSearch = () => {
    router.get(
        route('admin.index', {
            search: form.search,
            user_role: params.user_role,
        }),
    );
};

const handleToggleRole = (event) => {
    if (event.target.checked) {
        router.get(
            route('admin.index', {
                search: form.search,
                user_role: 'suspended',
            }),
        );
    } else {
        router.get(
            route('admin.index', {
                search: form.search,
                user_role: null,
            }),
        );
    }
};
</script>

<style></style>
