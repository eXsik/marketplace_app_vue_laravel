<template>
    <article class="listing-card">
        <Link
            :href="route('listing.show', listing.id)"
            class="listing-image-link"
        >
            <img
                :src="imageUrl"
                :alt="listing.title"
                class="listing-image"
                loading="lazy"
            />
            <span v-if="firstTag" class="listing-image-tag">
                {{ tagLabel(firstTag) }}
            </span>
        </Link>

        <div class="listing-card-content">
            <Link
                :href="route('listing.show', listing.id)"
                class="listing-title"
            >
                {{ listing.title }}
            </Link>
            <p class="listing-description">{{ listing.description }}</p>

            <div class="listing-card-footer">
                <Link
                    :href="route('home', { user_id: listing.user.id })"
                    class="listing-seller"
                >
                    <span class="seller-avatar" aria-hidden="true">
                        {{ listing.user.name.slice(0, 1).toUpperCase() }}
                    </span>
                    <span>{{ listing.user.name }}</span>
                </Link>
                <time :datetime="listing.created_at">{{ dateLabel }}</time>
            </div>
        </div>
    </article>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import { listingImageUrl } from '@/utils/listingImage';

const props = defineProps({ listing: Object });
const firstTag = computed(() => props.listing.tags?.split(',')[0]?.trim());
const imageUrl = computed(() => listingImageUrl(props.listing.image));
const dateLabel = computed(() =>
    new Intl.DateTimeFormat('pl-PL', { day: 'numeric', month: 'short' }).format(
        new Date(props.listing.created_at),
    ),
);

const tagNames = {
    dom: 'Dom i wnętrza',
    moda: 'Moda',
    rowery: 'Rowery',
    technologia: 'Technologia',
    ksiazki: 'Książki',
};
const tagLabel = (tag) => tagNames[tag] ?? tag;
</script>
