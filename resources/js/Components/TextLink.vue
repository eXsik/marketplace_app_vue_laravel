<template>
    <Link
        class="font-medium text-indigo-500 underline hover:text-indigo-600 dark:text-indigo-400 dark:hover:text-indigo-500"
        :href="route(routeName)"
    >
        {{ label }}
    </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    routeName: String,
    label: String,
});
</script>
