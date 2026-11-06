<template>
    <Head title="Odzyskaj hasło" />
    <Container class="max-w-screen-sm">
        <SessionMessages :status="status" class="my-4" />

        <div class="mb-8 text-center">
            <p class="my-4">
                Podaj adres e-mail przypisany do konta. Wyślemy Ci link do
                ustawienia nowego hasła.
            </p>
        </div>

        <ErrorMessages class="mb-4" :errors="form.errors" />

        <form class="space-y-6" @submit.prevent="submit">
            <InputField
                id="email"
                name="email"
                label="E-mail"
                type="email"
                autocomplete="email"
                :error="form.errors.email"
                v-model="form.email"
            >
                <AtSymbolIcon class="inline-block size-4" />
            </InputField>

            <PrimaryBtn :loading="form.processing">
                {{
                    form.processing
                        ? 'Wysyłanie…'
                        : 'Wyślij link do zmiany hasła'
                }}
            </PrimaryBtn>
        </form>
    </Container>
</template>

<script setup>
import Container from '@/Components/Container.vue';
import InputField from '@/Components/InputField.vue';
import { AtSymbolIcon } from '@heroicons/vue/24/outline';
import PrimaryBtn from '@/Components/PrimaryBtn.vue';
import { Head, useForm } from '@inertiajs/vue3';
import ErrorMessages from '@/Components/ErrorMessages.vue';
import SessionMessages from '@/Components/SessionMessages.vue';
import { nextTick } from 'vue';

const form = useForm({
    email: '',
});

defineProps({
    status: String,
});

const submit = () => {
    form.post(route('password.email'), { onError: focusFirstError });
};

const focusFirstError = async () => {
    await nextTick();
    document.querySelector('[aria-invalid="true"]')?.focus();
};
</script>
