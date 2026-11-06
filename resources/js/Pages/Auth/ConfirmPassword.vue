<template>
    <Head title="Potwierdź hasło" />
    <Container class="max-w-screen-sm">
        <div class="mb-8 text-center">
            <p class="my-4">
                To bezpieczna część aplikacji. Potwierdź hasło, aby kontynuować.
            </p>
        </div>

        <ErrorMessages class="mb-4" :errors="form.errors" />

        <form class="space-y-6" @submit.prevent="submit">
            <InputField
                id="password"
                name="password"
                label="Hasło"
                type="password"
                autocomplete="current-password"
                :error="form.errors.password"
                v-model="form.password"
            >
                <KeyIcon class="inline-block size-4" />
            </InputField>

            <PrimaryBtn :loading="form.processing">
                {{ form.processing ? 'Sprawdzanie…' : 'Potwierdź hasło' }}
            </PrimaryBtn>
        </form>
    </Container>
</template>

<script setup>
import Container from '@/Components/Container.vue';
import InputField from '@/Components/InputField.vue';
import { KeyIcon } from '@heroicons/vue/24/outline';
import PrimaryBtn from '@/Components/PrimaryBtn.vue';
import { Head, useForm } from '@inertiajs/vue3';
import ErrorMessages from '@/Components/ErrorMessages.vue';
import { nextTick } from 'vue';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onError: focusFirstError,
        onFinish: () => {
            form.reset();
        },
    });
};

const focusFirstError = async () => {
    await nextTick();
    document.querySelector('[aria-invalid="true"]')?.focus();
};
</script>
