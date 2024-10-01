<template>
    <Link
        :href="route(routeName)"
        class="rounded-lg px-3 py-2 hover:bg-slate-700"
    >
        <slot />
    </Link>
</template>

<script setup>
defineProps({
    routeName: String,
});
</script>
