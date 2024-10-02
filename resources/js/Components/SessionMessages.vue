<template>
    <div
        role="alert"
        v-if="status"
        class="rounded-xl border border-gray-100 bg-white p-4"
    >
        <div class="flex items-start gap-4">
            <span class="text-green-600">
                <CheckCircleIcon class="size-6 text-green-600" />
            </span>

            <div class="flex-1">
                <p class="ml-2 mt-1 text-sm text-green-600">
                    {{ status }}
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { CheckCircleIcon } from '@heroicons/vue/24/outline';
defineProps({
    status: String,
});
</script>
