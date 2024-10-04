<template>
    <Container class="mb-6">
        <div class="mb-6">
            <Title>Delete Account</Title>
            <p>
                Once your account is deleted, all of its resources data will be
                permanently deleted. This action cannot be undone.
            </p>
        </div>

        <ErrorMessages :errors="form.errors" />

        <div v-if="showDeleteAccount">
            <form class="space-y-6" @submit.prevent="submit">
                <InputField
                    label="Confirm Password"
                    class="w-1/2"
                    type="password"
                    v-model="form.password"
                >
                    <KeyIcon class="inline-block size-4" />
                </InputField>

                <SessionMessages
                    v-if="form.recentlySuccessful"
                    status="Password Saved!"
                />

                <div class="flex items-center gap-4">
                    <PrimaryBtn :disabled="form.processing">
                        Confim
                    </PrimaryBtn>
                    <button
                        @click="showDeleteAccount = false"
                        class="flex items-center justify-center gap-2 rounded-lg border border-slate-950 px-3 py-2 text-slate-950 shadow-md hover:bg-slate-50"
                    >
                        Cancel
                    </button>
                </div>
            </form>
        </div>

        <button
            v-if="!showDeleteAccount"
            @click="showDeleteAccount = true"
            class="flex items-center justify-center gap-2 rounded-lg border border-red-500 px-3 py-2 text-red-500 shadow-md hover:bg-red-50"
        >
            <ExclamationTriangleIcon class="inline-block size-4" />
            Delete Account
        </button>
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
import { ExclamationTriangleIcon, KeyIcon } from '@heroicons/vue/24/outline';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const showDeleteAccount = ref(false);

const form = useForm({
    password: '',
});

const submit = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onFinish: () => form.reset(),
    });
};
</script>

<style></style>
