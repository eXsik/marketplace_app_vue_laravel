<template>
    <Container class="mb-6">
        <div class="mb-6">
            <Title>Usuń konto</Title>
            <p class="text-sm leading-6 text-slate-600">
                Usunięcie konta skasuje również Twoje ogłoszenia. Tej operacji
                nie można cofnąć.
            </p>
        </div>

        <ErrorMessages :errors="form.errors" />

        <div
            v-if="showDeleteAccount"
            class="mt-5 rounded-xl border border-red-200 bg-red-50 p-4 sm:p-5"
        >
            <form class="space-y-5" @submit.prevent="submit">
                <InputField
                    id="delete-password"
                    name="password"
                    label="Potwierdź hasłem"
                    type="password"
                    autocomplete="current-password"
                    :error="form.errors.password"
                    v-model="form.password"
                >
                    <KeyIcon class="inline-block size-4" />
                </InputField>

                <div
                    class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-3"
                >
                    <PrimaryBtn :loading="form.processing">
                        {{ form.processing ? 'Usuwanie…' : 'Usuń konto' }}
                    </PrimaryBtn>
                    <button
                        type="button"
                        @click="showDeleteAccount = false"
                        class="inline-flex min-h-12 items-center justify-center rounded-lg border border-slate-300 px-5 text-sm font-semibold text-slate-700 hover:bg-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-blue-700"
                    >
                        Anuluj
                    </button>
                </div>
            </form>
        </div>

        <button
            v-if="!showDeleteAccount"
            @click="showDeleteAccount = true"
            class="inline-flex min-h-12 items-center justify-center gap-2 rounded-lg border border-red-300 px-4 text-sm font-bold text-red-800 hover:bg-red-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-700"
        >
            <ExclamationTriangleIcon class="inline-block size-4" />
            Usuń konto
        </button>
    </Container>
</template>

<script setup>
import Container from '@/Components/Container.vue';
import ErrorMessages from '@/Components/ErrorMessages.vue';
import InputField from '@/Components/InputField.vue';
import PrimaryBtn from '@/Components/PrimaryBtn.vue';
import Title from '@/Components/Title.vue';
import { ExclamationTriangleIcon, KeyIcon } from '@heroicons/vue/24/outline';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const showDeleteAccount = ref(false);

const form = useForm({
    password: '',
});

const submit = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onError: focusFirstError,
        onFinish: () => form.reset(),
    });
};

const focusFirstError = async () => {
    await nextTick();
    document.querySelector('[aria-invalid="true"]')?.focus();
};
</script>

<style></style>
