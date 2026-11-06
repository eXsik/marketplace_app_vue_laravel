<template>
    <Head title="Logowanie" />
    <Container class="max-w-screen-sm">
        <div class="mb-8 text-center">
            <Title>Zaloguj się</Title>
            <p class="my-4">
                Nie masz jeszcze konta?
                <TextLink label="Utwórz konto" routeName="register" />
            </p>
        </div>

        <SessionMessages :status="status" class="my-4" />

        <ErrorMessages class="mb-4" :errors="form.errors" />

        <form class="space-y-6" @submit.prevent="submit">
            <InputField
                id="email"
                name="email"
                label="E-mail"
                type="email"
                autocomplete="username"
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
                autocomplete="current-password"
                :error="form.errors.password"
                v-model="form.password"
            >
                <KeyIcon class="inline-block size-4" />
            </InputField>

            <div class="flex items-center justify-between">
                <Checkbox name="remember" v-model="form.remember">
                    Zapamiętaj mnie
                </Checkbox>
                <TextLink
                    routeName="password.request"
                    label="Nie pamiętasz hasła?"
                />
            </div>

            <PrimaryBtn :loading="form.processing">
                {{ form.processing ? 'Logowanie…' : 'Zaloguj się' }}
            </PrimaryBtn>
        </form>
    </Container>
</template>

<script setup>
import Container from '@/Components/Container.vue';
import Title from '@/Components/Title.vue';
import TextLink from '@/Components/TextLink.vue';
import InputField from '@/Components/InputField.vue';
import { AtSymbolIcon, KeyIcon } from '@heroicons/vue/24/outline';
import PrimaryBtn from '@/Components/PrimaryBtn.vue';
import { Head, useForm } from '@inertiajs/vue3';
import ErrorMessages from '@/Components/ErrorMessages.vue';
import Checkbox from '@/Components/Checkbox.vue';
import { nextTick } from 'vue';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

defineProps({
    status: String,
});

const submit = () => {
    form.post(route('login'), {
        onError: focusFirstError,
        onFinish: () => {
            form.reset('password');
        },
    });
};

const focusFirstError = async () => {
    await nextTick();
    document.querySelector('[aria-invalid="true"]')?.focus();
};
</script>
