<template>
    <Head title="Potwierdź e-mail" />

    <Container class="max-w-screen-sm">
        <SessionMessages :status="status" class="my-4" />
        <div class="mb-8">
            <p>
                Zanim zaczniesz, potwierdź adres e-mail, klikając link, który
                wysłaliśmy. Jeśli wiadomość nie dotarła, możesz poprosić o
                ponowne wysłanie.
            </p>
        </div>

        <ErrorMessages :errors="form.errors" />

        <form @submit.prevent="submit">
            <PrimaryBtn :loading="form.processing">
                {{ form.processing ? 'Wysyłanie…' : 'Wyślij link ponownie' }}
            </PrimaryBtn>
        </form>
    </Container>
</template>

<script setup>
import Container from '@/Components/Container.vue';
import PrimaryBtn from '@/Components/PrimaryBtn.vue';
import SessionMessages from '@/Components/SessionMessages.vue';
import ErrorMessages from '@/Components/ErrorMessages.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({});

defineProps({
    status: String,
});

const submit = () => {
    form.post(route('verification.send'));
};
</script>
