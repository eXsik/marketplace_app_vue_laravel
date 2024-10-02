<template>
    <Head title="- Forgot Password" />
    <Container class="max-w-screen-sm">
        <SessionMessages :status="status" class="my-4" />

        <div class="mb-8 text-center">
            <p class="my-4">
                Forgot your password? No problem. Just let us know your email
                address and we will email you a password reset link that will
                allow you to choose a new one.
            </p>
        </div>

        <ErrorMessages class="mb-4" :errors="form.errors" />

        <form class="space-y-6" @submit.prevent="submit">
            <InputField label="Email" v-model="form.email">
                <AtSymbolIcon class="inline-block size-4" />
            </InputField>

            <PrimaryBtn :disabled="form.processing">
                Send Password Reset Link
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

const form = useForm({
    email: '',
});

defineProps({
    status: String,
});

const submit = () => {
    form.post(route('password.email'));
};
</script>
