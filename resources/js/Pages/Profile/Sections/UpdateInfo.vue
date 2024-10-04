<template>
    <Container class="mb-6">
        <div class="mb-6">
            <Title>Update Information</Title>
            <p>Update your account's profile information and email address.</p>
        </div>

        <ErrorMessages :errors="form.errors" />

        <form class="space-y-6" @submit.prevent="submit">
            <InputField label="Name" class="w-1/2" v-model="form.name">
                <IdentificationIcon class="inline-block size-4" />
            </InputField>
            <InputField label="Email" class="w-1/2" v-model="form.email">
                <AtSymbolIcon class="inline-block size-4" />
            </InputField>

            <div v-if="!user.email_verified_at">
                <SessionMessages :status="status" />

                <p>
                    Your email address in unverified.
                    <button
                        class="font-medium text-indigo-500 underline disabled:cursor-not-allowed disabled:text-slate-400 dark:text-indigo-400"
                        @click="resendEmail"
                    >
                        Click here to re-send the verification email.
                    </button>
                </p>
            </div>

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
import Title from '@/Components/Title.vue';
import { AtSymbolIcon, IdentificationIcon } from '@heroicons/vue/24/outline';
import { router, useForm } from '@inertiajs/vue3';

const props = defineProps({
    user: Object,
    status: String,
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
});

const submit = () => {
    form.patch(route('profile.update'));
};

const resendEmail = (event) => {
    router.post(
        route('verification.send'),
        {},
        {
            onStart: () => (event.target.disabled = true),
            onFinish: () => (event.target.disabled = false),
        },
    );
};
</script>

<style></style>
