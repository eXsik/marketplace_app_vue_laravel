<template>
    <Head title="Utwórz konto" />
    <Container class="max-w-screen-sm">
        <div class="mb-8 text-center">
            <Title>Dołącz do społeczności</Title>
            <p class="my-4">
                Masz już konto?
                <TextLink label="Zaloguj się" routeName="login" />
            </p>
        </div>

        <ErrorMessages class="mb-4" :errors="form.errors" />

        <form class="space-y-6" @submit.prevent="submit">
            <InputField
                id="name"
                name="name"
                label="Imię i nazwisko"
                autocomplete="name"
                :error="form.errors.name"
                v-model="form.name"
            >
                <UserIcon class="inline-block size-4" />
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
            <InputField
                id="password"
                name="password"
                label="Hasło"
                type="password"
                autocomplete="new-password"
                :error="form.errors.password"
                v-model="form.password"
            >
                <KeyIcon class="inline-block size-4" />
            </InputField>
            <InputField
                id="password_confirmation"
                name="password_confirmation"
                label="Powtórz hasło"
                type="password"
                autocomplete="new-password"
                :error="form.errors.password_confirmation"
                v-model="form.password_confirmation"
            >
                <KeyIcon class="inline-block size-4" />
            </InputField>

            <p class="text-sm text-slate-500">
                Hasło powinno mieć co najmniej 8 znaków.
            </p>

            <PrimaryBtn :loading="form.processing">
                {{ form.processing ? 'Tworzenie konta…' : 'Utwórz konto' }}
            </PrimaryBtn>
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
import { nextTick } from 'vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onError: focusFirstError,
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        },
    });
};

const focusFirstError = async () => {
    await nextTick();
    document.querySelector('[aria-invalid="true"]')?.focus();
};
</script>
