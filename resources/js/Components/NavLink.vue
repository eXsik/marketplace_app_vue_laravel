<template>
    <Link
        :href="route(routeName)"
        class="rounded-lg px-3 py-2 hover:bg-slate-700"
        :class="{ 'bg-slate-700': $page.component === componentName }"
    >
        <slot />
    </Link>
</template>

<script setup>
defineProps({
    routeName: String,
    componentName: String,
});
</script>
