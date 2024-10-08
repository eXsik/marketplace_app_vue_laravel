<template>
    <div
        role="alert"
        v-if="Object.keys(errors).length"
        class="bg-red-white mb-4 rounded-xl border border-red-500 p-4"
    >
        <div class="flex items-center gap-2 text-red-500">
            <XCircleIcon class="size-5" />
            <strong class="block font-medium"> Something went wrong </strong>
        </div>

        <ul class="mt-2 text-sm text-red-500">
            <li v-for="(error, index) in errors" :key="index" class="my-0.5">
                - {{ error }}
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
