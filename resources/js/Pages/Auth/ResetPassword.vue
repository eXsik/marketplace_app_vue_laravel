<template>
    <Head title="Ustaw nowe hasło" />
    <Container class="max-w-screen-sm">
        <div class="mb-8 text-center">
            <Title>Ustaw nowe hasło</Title>
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
            <InputField
                id="password"
                name="password"
                label="Hasło"
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
                label="Powtórz hasło"
                type="password"
                autocomplete="new-password"
                :error="form.errors.password_confirmation"
                v-model="form.password_confirmation"
            >
                <KeyIcon class="inline-block size-4" />
            </InputField>

            <PrimaryBtn :loading="form.processing">
                {{ form.processing ? 'Zapisywanie…' : 'Zapisz nowe hasło' }}
            </PrimaryBtn>
        </form>
    </Container>
</template>

<script setup>
import Container from '@/Components/Container.vue';
import Title from '@/Components/Title.vue';
import InputField from '@/Components/InputField.vue';
import { AtSymbolIcon, KeyIcon } from '@heroicons/vue/24/outline';
import PrimaryBtn from '@/Components/PrimaryBtn.vue';
import { useForm } from '@inertiajs/vue3';
import ErrorMessages from '@/Components/ErrorMessages.vue';
import { nextTick } from 'vue';

const props = defineProps({
    token: String,
    email: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.update'), {
        onError: focusFirstError,
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        },
    });
};

const focusFirstError = async () => {
    await nextTick();
    document.querySelector('[aria-invalid="true"]')?.focus();
};
</script>
