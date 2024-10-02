<template>
    <Container class="max-w-screen-sm">
        <div class="mb-8 text-center">
            <Title>Register new account</Title>
            <p class="my-4">
                Already have an account?
                <TextLink label="Login" routeName="home" />
            </p>
        </div>

        <ErrorMessages class="mb-4" :errors="form.errors" />

        <form class="space-y-6" @submit.prevent="submit">
            <InputField label="Name" v-model="form.name">
                <UserIcon class="inline-block size-4" />
            </InputField>
            <InputField label="Email" v-model="form.email">
                <AtSymbolIcon class="inline-block size-4" />
            </InputField>
            <InputField
                label="Password"
                type="password"
                v-model="form.password"
            >
                <KeyIcon class="inline-block size-4" />
            </InputField>
            <InputField
                label="Confirm password"
                type="password"
                v-model="form.password_confirmation"
            >
                <KeyIcon class="inline-block size-4" />
            </InputField>

            <p class="text-sm text-slate-500 dark:text-slate-400">
                By creating an account, you agree to our Terms of Service and
                Privacy Policy.
            </p>

            <PrimaryBtn :disable="form.processing"> Register </PrimaryBtn>
        </form>
    </Container>
</template>

<script setup>
import Container from '@/Components/Container.vue';
import Title from '@/Components/Title.vue';
import TextLink from '@/Components/TextLink.vue';
import InputField from '@/Components/InputField.vue';
import { UserIcon, AtSymbolIcon, KeyIcon } from '@heroicons/vue/24/outline';
import PrimaryBtn from '@/Components/PrimaryBtn.vue';
import { useForm } from '@inertiajs/vue3';
import ErrorMessages from '@/Components/ErrorMessages.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        },
    });
};
</script>
