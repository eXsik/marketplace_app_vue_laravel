<template>
    <div
        v-if="errorEntries.length"
        role="alert"
        aria-live="assertive"
        class="mb-5 rounded-lg border border-red-200 bg-red-50 p-4 text-red-900"
    >
        <div class="flex items-start gap-3">
            <XCircleIcon class="mt-0.5 size-5 shrink-0 text-red-700" />
            <div>
                <h2 class="font-bold">Sprawdź poprawność formularza</h2>
                <ul class="mt-2 list-inside list-disc space-y-1 text-sm">
                    <li
                        v-for="([field, message], index) in errorEntries"
                        :key="index"
                    >
                        <span v-if="fieldLabels[field]" class="font-semibold">
                            {{ fieldLabels[field] }}:
                        </span>
                        {{ validationMessage(message, field) }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { XCircleIcon } from '@heroicons/vue/24/outline';
import { validationMessage } from '@/utils/validationMessage';

const props = defineProps({ errors: { type: Object, default: () => ({}) } });
const errorEntries = computed(() => Object.entries(props.errors || {}));
const fieldLabels = {
    title: 'Tytuł',
    description: 'Opis',
    tags: 'Tagi',
    email: 'E-mail',
    link: 'Link',
    image: 'Zdjęcie',
    name: 'Imię',
    password: 'Hasło',
    password_confirmation: 'Potwierdzenie hasła',
    current_password: 'Obecne hasło',
};
</script>
