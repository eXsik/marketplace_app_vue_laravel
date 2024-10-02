<template>
    <Head title="- Login" />
    <Container class="max-w-screen-sm">
        <div class="mb-8 text-center">
            <Title>Login to your account</Title>
            <p class="my-4">
                DOn't have an account?
                <TextLink label="Register" routeName="register" />
            </p>
        </div>

        <ErrorMessages class="mb-4" :errors="form.errors" />

        <form class="space-y-6" @submit.prevent="submit">
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

            <div class="flex items-center justify-between">
                <Checkbox name="remember" v-model="form.remember">
                    Remember me
                </Checkbox>
                <TextLink routeName="home" label="Forgot password?" />
            </div>

            <PrimaryBtn :disable="form.processing"> Login </PrimaryBtn>
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

const form = useForm({
    email: '',
    password: '',
    remembet: null,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
        },
    });
};
</script>
