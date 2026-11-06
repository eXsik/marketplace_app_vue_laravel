<template>
    <Head title="Moje ogłoszenia" />
    <SessionMessages :status="status" class="mb-6" />

    <section v-if="listings">
        <div
            class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between"
        >
            <div>
                <Title>Moje ogłoszenia</Title>
                <p class="mt-1 text-sm text-slate-600">
                    Zarządzaj swoimi ofertami i ich widocznością.
                </p>
            </div>
            <div class="flex flex-wrap gap-x-5 gap-y-2 text-xs text-slate-600">
                <p class="flex items-center gap-2">
                    <CheckCircleIcon
                        aria-hidden="true"
                        class="size-5 text-emerald-700"
                    />
                    Opublikowane
                </p>
                <p class="flex items-center gap-2">
                    <ClockIcon
                        aria-hidden="true"
                        class="size-5 text-amber-700"
                    />
                    Oczekują na akceptację
                </p>
            </div>
        </div>

        <div
            v-if="listings.data.length"
            class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm"
        >
            <table class="w-full min-w-[620px] border-collapse text-sm">
                <thead
                    class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500"
                >
                    <tr>
                        <th class="p-4 text-left">Ogłoszenie</th>
                        <th class="p-4 text-left">Status</th>
                        <th class="p-4 text-right">Akcje</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr v-for="listing in listings.data" :key="listing.id">
                        <td class="p-4">
                            <div class="flex min-w-0 items-center gap-3">
                                <img
                                    :src="listingImageUrl(listing.image)"
                                    alt=""
                                    class="size-14 shrink-0 rounded-lg object-cover"
                                />
                                <span class="max-w-md font-bold text-slate-800">
                                    {{ listing.title }}
                                </span>
                            </div>
                        </td>
                        <td class="p-4">
                            <span
                                class="inline-flex min-h-8 items-center gap-1.5 rounded-full px-3 text-xs font-bold"
                                :class="
                                    listing.approved
                                        ? 'bg-emerald-50 text-emerald-800'
                                        : 'bg-amber-50 text-amber-800'
                                "
                            >
                                <CheckCircleIcon
                                    v-if="listing.approved"
                                    aria-hidden="true"
                                    class="size-4"
                                />
                                <ClockIcon
                                    v-else
                                    aria-hidden="true"
                                    class="size-4"
                                />
                                {{
                                    listing.approved
                                        ? 'Opublikowane'
                                        : 'Oczekuje na akceptację'
                                }}
                            </span>
                        </td>
                        <td class="p-3 text-right">
                            <div class="flex justify-end gap-1">
                                <Link
                                    v-if="listing.approved"
                                    :href="route('listing.show', listing.id)"
                                    class="inline-flex min-h-11 items-center rounded-lg px-3 font-semibold text-blue-800 hover:bg-blue-50"
                                >
                                    Zobacz
                                </Link>
                                <Link
                                    :href="route('listing.edit', listing.id)"
                                    class="inline-flex min-h-11 items-center rounded-lg px-3 font-semibold text-blue-800 hover:bg-blue-50"
                                >
                                    Edytuj
                                </Link>
                                <button
                                    type="button"
                                    class="inline-flex min-h-11 items-center rounded-lg px-3 font-semibold text-red-700 hover:bg-red-50"
                                    @click="deleteListing(listing.id)"
                                >
                                    Usuń
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="empty-state">
            <PlusIcon aria-hidden="true" class="size-8 text-blue-700" />
            <h2>Nie masz jeszcze ogłoszeń</h2>
            <p>
                Dodaj pierwsze i pokaż innym przedmiot, któremu dasz drugie
                życie.
            </p>
            <Link :href="route('listing.create')" class="empty-state-link">
                Dodaj ogłoszenie
            </Link>
        </div>

        <div v-if="listings.data.length" class="mt-6">
            <PaginationLinks :paginator="listings" />
        </div>
    </section>

    <section
        v-else
        class="rounded-xl border border-amber-200 bg-amber-50 p-5 text-amber-950"
    >
        <h2 class="font-bold">Konto jest zawieszone</h2>
        <p class="mt-1 text-sm">
            Nie możesz teraz zarządzać ogłoszeniami. Skontaktuj się z
            administracją, aby wyjaśnić sytuację.
        </p>
    </section>
</template>

<script setup>
import { listingImageUrl } from '@/utils/listingImage';
import PaginationLinks from '@/Components/PaginationLinks.vue';
import SessionMessages from '@/Components/SessionMessages.vue';
import Title from '@/Components/Title.vue';
import {
    CheckCircleIcon,
    ClockIcon,
    PlusIcon,
} from '@heroicons/vue/24/outline';
import { Link, router } from '@inertiajs/vue3';

defineProps({ listings: Object, status: String });

const deleteListing = (id) => {
    if (confirm('Czy na pewno chcesz usunąć to ogłoszenie?')) {
        router.delete(route('listing.destroy', id));
    }
};
</script>
