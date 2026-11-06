<template>
    <Container class="mb-6">
        <div class="mb-6">
            <Title>Zmień hasło</Title>
            <p class="text-sm text-slate-600">
                Użyj unikalnego hasła o długości co najmniej 8 znaków.
            </p>
        </div>

        <ErrorMessages :errors="form.errors" />

        <form class="space-y-5" @submit.prevent="submit">
            <InputField
                id="current_password"
                name="current_password"
                label="Obecne hasło"
                type="password"
                autocomplete="current-password"
                :error="form.errors.current_password"
                v-model="form.current_password"
            >
                <KeyIcon class="inline-block size-4" />
            </InputField>

            <InputField
                id="password"
                name="password"
                label="Nowe hasło"
                type="password"
                autocomplete="new-password"
                :error="form.errors.password"
                v-model="form.password"
            >
                <KeyIcon class="inline-block size-4" />
            </InputField>

            <InputField
                id="password_confirmation"
                name="password_confirmation"
                label="Powtórz nowe hasło"
                type="password"
                autocomplete="new-password"
                :error="form.errors.password_confirmation"
                v-model="form.password_confirmation"
            >
                <KeyIcon class="inline-block size-4" />
            </InputField>

            <SessionMessages
                v-if="form.recentlySuccessful"
                status="Hasło zostało zmienione."
            />

            <PrimaryBtn :loading="form.processing">
                {{ form.processing ? 'Zapisywanie…' : 'Zmień hasło' }}
            </PrimaryBtn>
        </form>
    </Container>
</template>

<script setup>
import Container from '@/Components/Container.vue';
import ErrorMessages from '@/Components/ErrorMessages.vue';
import InputField from '@/Components/InputField.vue';
import PrimaryBtn from '@/Components/PrimaryBtn.vue';
import SessionMessages from '@/Components/SessionMessages.vue';
import Title from '@/Components/Title.vue';
import { KeyIcon } from '@heroicons/vue/24/outline';
import { useForm } from '@inertiajs/vue3';
import { nextTick } from 'vue';

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.put(route('profile.password'), {
        preserveScroll: true,
        onError: focusFirstError,
        onFinish: () => form.reset(),
    });
};

const focusFirstError = async () => {
    await nextTick();
    document.querySelector('[aria-invalid="true"]')?.focus();
};
</script>

<style></style>
