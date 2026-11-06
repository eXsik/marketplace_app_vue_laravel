<template>
    <div class="flex min-h-11 items-center gap-3">
        <input
            type="checkbox"
            :name="name"
            :id="name"
            v-model="model"
            class="size-5 cursor-pointer rounded border-slate-400 text-blue-700 focus-visible:ring-2 focus-visible:ring-blue-700"
        />
        <label
            :for="name"
            class="flex min-h-11 cursor-pointer items-center text-sm font-medium text-slate-700"
        >
            <slot />
        </label>
    </div>
</template>

<script setup>
const model = defineModel();

defineProps({
    name: String,
});
</script>
