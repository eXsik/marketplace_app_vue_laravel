<template>
    <Head :title="listing.title" />

    <div
        v-if="$page.props.auth.user?.role === 'admin'"
        class="mb-5 flex flex-col gap-4 rounded-xl border border-blue-200 bg-blue-50 p-4 text-blue-950 sm:flex-row sm:items-center sm:justify-between sm:p-5"
    >
        <p class="font-semibold">
            Status ogłoszenia:
            {{ listing.approved ? 'opublikowane' : 'oczekuje na akceptację' }}
        </p>

        <button
            @click.prevent="toggleApprove"
            class="inline-flex min-h-11 items-center justify-center rounded-lg bg-blue-800 px-4 text-sm font-bold text-white hover:bg-blue-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-900"
        >
            {{
                listing.approved ? 'Odrzuć ogłoszenie' : 'Zaakceptuj ogłoszenie'
            }}
        </button>
    </div>

    <Container class="flex flex-col gap-6 md:flex-row">
        <div class="w-full overflow-hidden rounded-md md:w-1/3">
            <img
                :src="listingImageUrl(listing.image)"
                :alt="listing.title + ' image'"
                class="h-64 w-full object-cover object-center md:h-full"
            />
        </div>

        <div class="w-full md:w-2/3">
            <div class="mb-7">
                <div
                    class="mb-4 flex flex-col gap-3 border-b border-slate-200 pb-3 sm:flex-row sm:items-center sm:justify-between"
                >
                    <p
                        class="text-xs font-bold uppercase tracking-wider text-blue-800"
                    >
                        O ogłoszeniu
                    </p>

                    <div v-if="canModify" class="flex flex-wrap gap-2">
                        <Link
                            :href="route('listing.edit', listing.id)"
                            class="inline-flex min-h-11 items-center justify-center rounded-lg border border-slate-300 px-4 text-sm font-bold text-slate-700 hover:bg-slate-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700"
                        >
                            Edytuj</Link
                        >

                        <button
                            @click="deleteListing"
                            type="button"
                            class="inline-flex min-h-11 items-center justify-center rounded-lg px-4 text-sm font-bold text-red-700 hover:bg-red-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-700"
                        >
                            Usuń
                        </button>
                    </div>
                </div>
                <h1
                    class="font-display mb-4 text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl"
                >
                    {{ listing.title }}
                </h1>
                <p
                    class="whitespace-pre-line text-base leading-7 text-slate-700"
                >
                    {{ listing.description }}
                </p>
            </div>

            <div class="mb-7">
                <p
                    class="mb-3 border-b border-slate-200 pb-3 text-xs font-bold uppercase tracking-wider text-blue-800"
                >
                    Kontakt i sprzedający
                </p>

                <div
                    v-if="listing.email"
                    class="mb-3 flex flex-wrap items-center gap-x-2 gap-y-1 text-sm"
                >
                    <AtSymbolIcon
                        aria-hidden="true"
                        class="inline-block size-4 text-slate-500"
                    />
                    <p class="text-slate-500">E-mail</p>
                    <a
                        :href="`mailto:${listing.email}`"
                        class="font-semibold text-blue-800 underline decoration-blue-200 underline-offset-4 hover:decoration-blue-800"
                    >
                        {{ listing.email }}
                    </a>
                </div>

                <div
                    v-if="listing.link"
                    class="mb-3 flex flex-wrap items-center gap-x-2 gap-y-1 text-sm"
                >
                    <ShareIcon
                        aria-hidden="true"
                        class="inline-block size-4 text-slate-500"
                    />
                    <p class="text-slate-500">Link</p>
                    <a
                        :href="listing.link"
                        class="break-all font-semibold text-blue-800 underline decoration-blue-200 underline-offset-4 hover:decoration-blue-800"
                        target="_blank"
                        rel="nofollow"
                    >
                        {{ listing.link }}
                    </a>
                </div>
                <div class="flex items-center gap-2 text-sm">
                    <UserIcon
                        aria-hidden="true"
                        class="inline-block size-4 text-slate-500"
                    />
                    <p class="text-slate-500">Sprzedający</p>
                    <Link
                        :href="route('home', { user_id: user.id })"
                        class="font-semibold text-blue-800 underline decoration-blue-200 underline-offset-4 hover:decoration-blue-800"
                    >
                        {{ user.name }}
                    </Link>
                </div>
            </div>

            <div v-if="listing.tags" class="mb-2">
                <p
                    class="mb-3 border-b border-slate-200 pb-3 text-xs font-bold uppercase tracking-wider text-blue-800"
                >
                    Tagi
                </p>

                <div class="flex items-center gap-3">
                    <div v-for="tag in listing.tags.split(',')" :key="tag">
                        <Link
                            :href="route('home', { tag })"
                            class="inline-flex min-h-10 items-center rounded-full border border-slate-200 bg-slate-50 px-3 text-sm font-semibold text-slate-700 transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700"
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
import { listingImageUrl } from '@/utils/listingImage';
import { AtSymbolIcon, ShareIcon, UserIcon } from '@heroicons/vue/24/outline';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
    listing: Object,
    user: Object,
    canModify: Boolean,
});

const deleteListing = () => {
    if (confirm('Czy na pewno chcesz usunąć to ogłoszenie?')) {
        router.delete(route('listing.destroy', props.listing.id));
    }
};

const toggleApprove = () => {
    let msg = props.listing.approved
        ? 'Odrzucić to ogłoszenie?'
        : 'Zaakceptować to ogłoszenie?';

    if (confirm(msg)) {
        router.put(route('admin.approve', props.listing.id));
    }
};
</script>
