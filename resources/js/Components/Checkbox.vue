<template>
    <div class="flex items-center gap-2">
        <input
            type="checkbox"
            :name="name"
            :id="name"
            v-model="model"
            class="border-1 rounded-md border-slate-700 text-indigo-500 outline-0 ring-indigo-500"
        />
        <label
            :for="name"
            class="block cursor-pointer text-sm font-medium text-slate-700 dark:text-slate-300"
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
