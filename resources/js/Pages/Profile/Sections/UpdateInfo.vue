<template>
    <Container class="mb-6">
        <div class="mb-6">
            <Title>Dane profilu</Title>
            <p class="text-sm text-slate-600">
                Zarządzaj nazwą i adresem e-mail przypisanym do konta.
            </p>
        </div>

        <ErrorMessages :errors="form.errors" />

        <form class="space-y-5" @submit.prevent="submit">
            <InputField
                id="name"
                name="name"
                label="Imię i nazwisko"
                autocomplete="name"
                :error="form.errors.name"
                v-model="form.name"
            >
                <IdentificationIcon class="inline-block size-4" />
            </InputField>
            <InputField
                id="email"
                name="email"
                label="E-mail"
                type="email"
                autocomplete="email"
                :error="form.errors.email"
                v-model="form.email"
            >
                <AtSymbolIcon class="inline-block size-4" />
            </InputField>

            <div v-if="!user.email_verified_at">
                <SessionMessages :status="status" />

                <p class="text-sm text-slate-700">
                    Twój adres e-mail nie został jeszcze potwierdzony.
                    <button
                        type="button"
                        class="inline-flex min-h-11 items-center font-semibold text-blue-800 underline underline-offset-4 disabled:cursor-not-allowed disabled:text-slate-400"
                        @click="resendEmail"
                    >
                        Wyślij ponownie link weryfikacyjny
                    </button>
                </p>
            </div>

            <PrimaryBtn :loading="form.processing">
                {{ form.processing ? 'Zapisywanie…' : 'Zapisz dane' }}
            </PrimaryBtn>
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
import { nextTick } from 'vue';

const props = defineProps({
    user: Object,
    status: String,
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
});

const submit = () => {
    form.patch(route('profile.update'), { onError: focusFirstError });
};

const focusFirstError = async () => {
    await nextTick();
    document.querySelector('[aria-invalid="true"]')?.focus();
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
