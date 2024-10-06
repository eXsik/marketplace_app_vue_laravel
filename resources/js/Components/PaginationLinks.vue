<template>
    <div class="flex items-start justify-between">
        <div class="flex items-center overflow-hidden rounded-md shadow-lg">
            <div v-for="(link, index) in paginator.links" :key="index">
                <component
                    :is="link.url ? 'Link' : 'span'"
                    :href="link.url"
                    class="grid size-12 place-items-center border-x border-slate-50 bg-white dark:border-slate-800 dark:bg-slate-900"
                    :class="{
                        'hover:bg-slate-300 dark:hover:bg-slate-500': link.url,
                        'text-slate-300': !link.url,
                        'font-bold text-indigo-500 dark:text-indigo-400':
                            link.active,
                    }"
                >
                    <span v-html="makeLabel(link.label)"></span
                ></component>
            </div>
        </div>
        <p class="text-sm text-slate-600 dark:text-slate-400">
            Showing {{ paginator.from }} to {{ paginator.to }} of
            {{ paginator.total }} results
        </p>
    </div>
</template>

<script setup>
defineProps({
    paginator: Object,
});

const makeLabel = (label) => {
    if (label.includes('Previous')) {
        return '<<';
    } else if (label.includes('Next')) {
        return '>>';
    } else {
        return label;
    }
};
</script>
