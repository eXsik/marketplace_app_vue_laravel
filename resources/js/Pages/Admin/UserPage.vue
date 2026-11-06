<template>
    <Head :title="`Ogłoszenia: ${user.name}`" />

    <SessionMessages :status="status" class="my-4" />
    <!-- Heading -->
    <div class="mb-6">
        <Title>Ogłoszenia: {{ user.name }}</Title>
        <p class="mb-4 mt-1 text-sm text-slate-600">
            Przeglądaj oferty i zarządzaj ich publikacją.
        </p>
        <div
            class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between"
        >
            <div class="flex items-end gap-2">
                <form @submit.prevent="handleSearch">
                    <InputField
                        label=""
                        ariaLabel="Szukaj ogłoszeń użytkownika"
                        placeholder="Szukaj ogłoszeń…"
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
            <div class="flex min-h-11 items-center gap-3 rounded-md text-xs">
                <input
                    @input="handleShowDisapproved"
                    :checked="params.disapproved"
                    type="checkbox"
                    id="showDisapproved"
                    class="size-5 cursor-pointer rounded border-slate-400 text-blue-700 focus-visible:ring-2 focus-visible:ring-blue-700"
                />
                <label
                    for="showDisapproved"
                    class="flex min-h-11 cursor-pointer items-center text-sm font-medium text-slate-700"
                >
                    Pokaż odrzucone ogłoszenia
                </label>
            </div>
        </div>
    </div>
    <div
        v-if="listings.data.length"
        class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm"
    >
        <table class="w-full min-w-[620px] overflow-hidden bg-white">
            <thead>
                <tr
                    class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-600"
                >
                    <th class="w-4/6 p-4 text-left">Ogłoszenie</th>
                    <th class="w-2/6 p-4 text-center">Status</th>
                    <th class="w-1/6 p-4 text-right">Podgląd</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                <tr
                    v-for="listing in listings.data"
                    :key="listing.id"
                    class="border-b border-slate-100 last:border-0"
                >
                    <td class="px-4 py-4 font-semibold text-slate-800">
                        {{ listing.title }}
                    </td>
                    <td class="h-full px-4 py-3 text-center">
                        <button
                            type="button"
                            :aria-label="`${listing.approved ? 'Odrzuć' : 'Zaakceptuj'} ogłoszenie ${listing.title}`"
                            class="inline-flex min-h-11 min-w-11 items-center justify-center rounded-lg hover:bg-slate-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-700"
                            @click.prevent="toggleApprove(listing)"
                        >
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
                    <td class="w-1/6 px-4 py-3 text-right">
                        <Link
                            :href="route('listing.show', listing.id)"
                            :aria-label="`Otwórz ogłoszenie ${listing.title}`"
                            class="inline-flex min-h-11 min-w-11 items-center justify-center rounded-lg text-blue-800 hover:bg-blue-50"
                        >
                            <ArrowTopRightOnSquareIcon class="size-5" />
                        </Link>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div v-else class="empty-state">
        <h2>Brak ogłoszeń do wyświetlenia</h2>
        <p>Zmień wyszukiwaną frazę lub ustawienia filtra.</p>
    </div>
    <div class="mt-6">
        <PaginationLinks v-if="listings.data.length" :paginator="listings" />
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
        ? 'Odrzucić to ogłoszenie?'
        : 'Zaakceptować to ogłoszenie?';

    if (confirm(msg)) {
        router.put(route('admin.approve', listing.id));
    }
};
</script>
