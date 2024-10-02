<template>
    <Head title="- Password Confirmation" />
    <Container class="max-w-screen-sm">
        <div class="mb-8 text-center">
            <p class="my-4">
                This is a secure area of the application. Please confirm your
                password before continuing.
            </p>
        </div>

        <ErrorMessages class="mb-4" :errors="form.errors" />

        <form class="space-y-6" @submit.prevent="submit">
            <InputField
                label="Password"
                type="password"
                v-model="form.password"
            >
                <KeyIcon class="inline-block size-4" />
            </InputField>

            <PrimaryBtn :disabled="form.processing"> Confirm </PrimaryBtn>
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

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => {
            form.reset();
        },
    });
};
</script>
