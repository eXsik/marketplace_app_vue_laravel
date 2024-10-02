<template>
    <div
        role="alert"
        v-if="Object.keys(errors).length"
        class="rounded border-s-4 border-red-500 bg-red-50 p-4"
    >
        <div class="flex items-center gap-2 text-red-800">
            <XCircleIcon class="size-5" />
            <strong class="block font-medium"> Something went wrong </strong>
        </div>

        <ul class="mt-2 list-none text-sm text-red-700">
            <li v-for="(error, index) in errors" :key="index" class="my-0.5">
                {{ error }}
            </li>
        </ul>
    </div>
</template>

<script setup>
import { XCircleIcon } from '@heroicons/vue/24/outline';

defineProps({
    errors: Object,
});
</script>
