<template>
    <Container class="mb-6">
        <div class="mb-6">
            <Title>Update Password</Title>
            <p>
                Ensure that you are using a long, random password to stay
                secure.
            </p>
        </div>

        <ErrorMessages :errors="form.errors" />

        <form class="space-y-6" @submit.prevent="submit">
            <InputField
                label="Current Password"
                class="w-1/2"
                type="password"
                v-model="form.current_password"
            >
                <KeyIcon class="inline-block size-4" />
            </InputField>

            <InputField
                label="New password"
                class="w-1/2"
                type="password"
                v-model="form.password"
            >
                <KeyIcon class="inline-block size-4" />
            </InputField>

            <InputField
                label="Confirm Password"
                class="w-1/2"
                type="password"
                v-model="form.password_confirmation"
            >
                <KeyIcon class="inline-block size-4" />
            </InputField>

            <SessionMessages
                v-if="form.recentlySuccessful"
                status="Password Saved!"
            />

            <PrimaryBtn :disabled="form.processing">Save</PrimaryBtn>
        </form>
    </Container>
</template>

<script setup>
import Container from '@/Components/Container.vue';
import ErrorMessages from '@/Components/ErrorMessages.vue';
import InputField from '@/Components/InputField.vue';
import PrimaryBtn from '@/Components/PrimaryBtn.vue';
import SessionMessages from '@/Components/SessionMessages.vue';
// import SessionMessages from '@/Components/SessionMessages.vue';
import Title from '@/Components/Title.vue';
import { KeyIcon } from '@heroicons/vue/24/outline';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.put(route('profile.password'), {
        preserveScroll: true,
        onFinish: () => form.reset(),
    });
};
</script>

<style></style>
