<template>
    <Head title="Rzeczy z drugiego obiegu" />

    <section class="market-hero">
        <div class="market-hero-copy">
            <p class="market-kicker">Dobre rzeczy, dobre historie</p>
            <h1>Znajdź coś,<br /><span>co zostanie</span></h1>
            <p class="market-intro">
                Przedmioty z charakterem, od ludzi z Twojej okolicy. Daj im
                drugie życie albo znajdź coś, czego właśnie potrzebujesz.
            </p>
            <form class="market-search" @submit.prevent="handleSearch">
                <MagnifyingGlassIcon class="size-5 shrink-0 text-slate-400" />
                <input
                    v-model="form.search"
                    type="search"
                    aria-label="Szukaj ogłoszeń"
                    placeholder="Czego szukasz?"
                />
                <button
                    type="submit"
                    :disabled="isSearching"
                    :aria-busy="isSearching"
                >
                    <ArrowPathIcon
                        v-if="isSearching"
                        aria-hidden="true"
                        class="size-4 animate-spin"
                    />
                    {{ isSearching ? 'Szukam…' : 'Szukaj' }}
                </button>
            </form>
        </div>

        <div class="market-hero-art" aria-hidden="true">
            <div class="hero-art-sun"></div>
            <div class="hero-art-shape hero-art-shape-back"></div>
            <div class="hero-art-shape hero-art-shape-front">
                <div class="chair-seat"></div>
                <div class="chair-back"></div>
                <div class="chair-leg chair-leg-left"></div>
                <div class="chair-leg chair-leg-right"></div>
            </div>
            <div class="hero-art-label">Przedmioty z historią</div>
            <SparklesIcon class="hero-art-sparkle size-8" />
        </div>
    </section>

    <nav class="category-strip" aria-label="Kategorie ogłoszeń">
        <span class="category-heading">Przeglądaj</span>
        <Link
            v-for="category in categories"
            :key="category.tag"
            :href="route('home', { ...params, tag: category.tag, page: null })"
            class="category-link"
            :class="{
                'category-link-active': category.tag
                    ? params.tag === category.tag
                    : !params.tag,
            }"
            :aria-current="
                (category.tag ? params.tag === category.tag : !params.tag)
                    ? 'page'
                    : undefined
            "
        >
            {{ category.label }}
        </Link>
    </nav>

    <section class="listing-section" :aria-busy="isSearching">
        <div class="listing-section-heading">
            <div>
                <p class="market-kicker">
                    {{ params.tag ? 'Wybrana kategoria' : 'Nowe odkrycia' }}
                </p>
                <h2>{{ sectionTitle }}</h2>
            </div>
            <p v-if="listings.total" class="results-count" aria-live="polite">
                {{ listings.total }} {{ listingWord(listings.total) }}
            </p>
        </div>

        <div v-if="listings.data.length" class="listing-grid">
            <Card
                v-for="listing in listings.data"
                :key="listing.id"
                :listing="listing"
            />
        </div>

        <div v-else class="empty-state">
            <MagnifyingGlassIcon class="size-8 text-blue-700" />
            <h3>Nie znaleźliśmy takich ogłoszeń</h3>
            <p>Spróbuj innej frazy lub wyczyść aktywne filtry.</p>
            <Link :href="route('home')" class="empty-state-link">
                Pokaż wszystkie ogłoszenia
            </Link>
        </div>

        <div v-if="listings.data.length" class="mt-10">
            <PaginationLinks :paginator="listings" />
        </div>
    </section>
</template>

<script setup>
import Card from '@/Components/Card.vue';
import PaginationLinks from '@/Components/PaginationLinks.vue';
import {
    ArrowPathIcon,
    MagnifyingGlassIcon,
    SparklesIcon,
} from '@heroicons/vue/24/outline';
import { Link, router, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const params = route().params;
const props = defineProps({
    listings: Object,
    searchTerm: String,
});

const categories = [
    { label: 'Wszystko', tag: null },
    { label: 'Dom i wnętrza', tag: 'dom' },
    { label: 'Moda', tag: 'moda' },
    { label: 'Rowery', tag: 'rowery' },
    { label: 'Technologia', tag: 'technologia' },
    { label: 'Książki', tag: 'ksiazki' },
];

const form = useForm({ search: props.searchTerm ?? '' });
const isSearching = ref(false);
const sectionTitle = computed(() => {
    if (params.search) return `Wyniki dla „${params.search}”`;
    if (params.tag) {
        return (
            categories.find((category) => category.tag === params.tag)?.label ??
            `Ogłoszenia: ${params.tag}`
        );
    }
    return 'Rzeczy warte odkrycia';
});

const listingWord = (count) => {
    if (count === 1) return 'ogłoszenie';
    if ([2, 3, 4].includes(count % 10) && ![12, 13, 14].includes(count % 100)) {
        return 'ogłoszenia';
    }
    return 'ogłoszeń';
};

const handleSearch = () => {
    router.get(
        route('home'),
        {
            search: form.search || null,
            tag: params.tag,
            user_id: params.user_id,
        },
        {
            preserveState: true,
            preserveScroll: true,
            onStart: () => (isSearching.value = true),
            onFinish: () => (isSearching.value = false),
        },
    );
};
</script>
