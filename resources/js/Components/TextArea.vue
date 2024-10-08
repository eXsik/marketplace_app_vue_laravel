<template>
    <div>
        <label
            :for="label"
            class="block text-sm font-medium text-slate-700 dark:text-slate-300"
        >
            {{ label }}
        </label>
        <div class="relative mt-1 rounded-md">
            <div
                class="pointer-events-none absolute left-0 top-3 flex items-center pl-3"
            >
                <span class="grid place-content-center text-sm text-slate-400">
                    <slot />
                </span>
            </div>
            <textarea
                :name="label"
                :placeholder="placeholder"
                rows="6"
                v-model="model"
                class="block w-full rounded-md border-slate-300 pl-9 pr-3 text-sm outline-0 placeholder:text-slate-400 focus:border-indigo-400 focus:ring-1 focus:ring-inset focus:ring-indigo-400 dark:text-slate-900"
            ></textarea>
        </div>
    </div>
</template>

<script setup>
const model = defineModel();

defineProps({
    label: String,
    placeholder: {
        type: String,
        default: '',
    },
});
</script>
