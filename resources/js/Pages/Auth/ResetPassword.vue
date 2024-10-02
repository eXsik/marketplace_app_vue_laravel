<template>
    <Head title="- Reset Password" />
    <Container class="max-w-screen-sm">
        <div class="mb-8 text-center">
            <Title>Enter your new password</Title>
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
            <InputField
                label="Confirm password"
                type="password"
                v-model="form.password_confirmation"
            >
                <KeyIcon class="inline-block size-4" />
            </InputField>

            <PrimaryBtn :disable="form.processing"> Reset Password </PrimaryBtn>
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
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        },
    });
};
</script>
