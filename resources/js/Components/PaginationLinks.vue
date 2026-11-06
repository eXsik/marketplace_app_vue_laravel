<template>
    <div
        class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
    >
        <nav
            aria-label="Strony wyników"
            class="flex max-w-full items-center overflow-x-auto rounded-lg border border-slate-200 bg-white shadow-sm"
        >
            <div v-for="(link, index) in paginator.links" :key="index">
                <component
                    :is="link.url ? 'Link' : 'span'"
                    :href="link.url"
                    :aria-label="accessibleLabel(link.label)"
                    :aria-current="link.active ? 'page' : undefined"
                    class="grid size-12 shrink-0 place-items-center border-r border-slate-100 text-sm text-slate-600 last:border-r-0"
                    :class="{
                        'hover:bg-blue-50 hover:text-blue-800': link.url,
                        'cursor-default text-slate-300': !link.url,
                        'bg-blue-50 font-bold text-blue-800': link.active,
                    }"
                >
                    <span aria-hidden="true">{{ makeLabel(link.label) }}</span>
                </component>
            </div>
        </nav>
        <p class="text-sm text-slate-600" aria-live="polite">
            Wyświetlanie {{ paginator.from }}–{{ paginator.to }} z
            {{ paginator.total }} wyników
        </p>
    </div>
</template>

<script setup>
defineProps({
    paginator: Object,
});

const makeLabel = (label) => {
    if (label.toLowerCase().includes('previous')) {
        return '‹';
    } else if (label.toLowerCase().includes('next')) {
        return '›';
    } else {
        return label;
    }
};

const accessibleLabel = (label) => {
    if (label.toLowerCase().includes('previous')) return 'Poprzednia strona';
    if (label.toLowerCase().includes('next')) return 'Następna strona';
    return `Strona ${label}`;
};
</script>
