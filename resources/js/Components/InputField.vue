<template>
    <div class="field-group">
        <label
            v-if="label"
            :for="fieldId"
            class="block text-sm font-semibold text-slate-700"
        >
            {{ label }}
        </label>
        <div class="relative mt-1.5">
            <div
                v-if="$slots.default"
                aria-hidden="true"
                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400"
            >
                <slot />
            </div>
            <input
                :id="fieldId"
                :type="type"
                :name="name || fieldId"
                :placeholder="placeholder"
                :autocomplete="autocomplete"
                :inputmode="inputmode"
                :required="required"
                :aria-label="label ? undefined : ariaLabel || placeholder"
                :aria-invalid="displayError ? 'true' : undefined"
                :aria-describedby="
                    displayError ? `${fieldId}-error` : undefined
                "
                v-model="model"
                class="block min-h-12 w-full rounded-lg border border-slate-300 bg-white px-4 text-base text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 aria-[invalid=true]:border-red-600 aria-[invalid=true]:focus:ring-red-600/20"
                :class="$slots.default ? 'pl-11' : ''"
            />
        </div>
        <p
            v-if="displayError"
            :id="`${fieldId}-error`"
            class="mt-1.5 text-sm font-medium text-red-700"
        >
            {{ displayError }}
        </p>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { validationMessage } from '@/utils/validationMessage';

const props = defineProps({
    id: String,
    name: String,
    label: String,
    ariaLabel: String,
    placeholder: { type: String, default: '' },
    type: { type: String, default: 'text' },
    autocomplete: String,
    inputmode: String,
    required: Boolean,
    error: String,
});

const model = defineModel();
const displayError = computed(() =>
    validationMessage(props.error, props.name || props.id),
);
const fieldId = computed(
    () =>
        props.id ||
        `field-${(props.name || props.label || 'input')
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-|-$/g, '')}`,
);
</script>
