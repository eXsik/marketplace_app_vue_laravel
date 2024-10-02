<template>
    <Head title="- Email Verification" />

    <Container class="max-w-screen-sm">
        <SessionMessages :status="status" class="my-4" />
        <div class="mb-8">
            <p>
                Thanks for singing up! Before getting started, could you verify
                your email address by clicking on the link we just emailed to
                you? If you didn't receive the email, we will gladly send you
                another.
            </p>
        </div>

        <form @submit.prevent="submit">
            <PrimaryBtn :disabled="form.processing">
                Resend Verification Email
            </PrimaryBtn>
        </form>
    </Container>
</template>

<script setup>
import Container from '@/Components/Container.vue';
import PrimaryBtn from '@/Components/PrimaryBtn.vue';
import SessionMessages from '@/Components/SessionMessages.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({});

defineProps({
    status: String,
});

const submit = () => {
    form.post(route('verification.send'));
};
</script>
