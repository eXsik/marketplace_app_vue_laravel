<template>
    <Head title="Edytuj ogłoszenie" />
    <Container>
        <div class="mb-6">
            <Title>Edytuj ogłoszenie</Title>
            <p class="mt-2 max-w-xl text-sm leading-6 text-slate-600">
                Zaktualizuj informacje lub zdjęcie. Zmiany pojawią się po
                zapisaniu.
            </p>
        </div>

        <ErrorMessages :errors="form.errors" />

        <form @submit.prevent="handleSubmit">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 sm:gap-6">
                <InputField
                    id="title"
                    name="title"
                    label="Tytuł"
                    placeholder="Na przykład: Fotel z lat 60."
                    :required="true"
                    :error="form.errors.title"
                    v-model="form.title"
                >
                    <PencilSquareIcon class="inline-block size-4" />
                </InputField>

                <InputField
                    id="tags"
                    name="tags"
                    label="Tagi (oddziel przecinkami)"
                    placeholder="dom, vintage, meble"
                    :error="form.errors.tags"
                    v-model="form.tags"
                >
                    <TagIcon class="inline-block size-4" />
                </InputField>
            </div>

            <div
                class="mt-5 grid grid-cols-1 gap-5 sm:mt-6 sm:grid-cols-2 sm:gap-6"
            >
                <InputField
                    id="email"
                    name="email"
                    label="E-mail do kontaktu"
                    placeholder="adres@example.com"
                    type="email"
                    autocomplete="email"
                    :error="form.errors.email"
                    v-model="form.email"
                >
                    <AtSymbolIcon class="inline-block size-4" />
                </InputField>

                <InputField
                    id="link"
                    name="link"
                    label="Link zewnętrzny"
                    placeholder="https://example.com"
                    type="url"
                    inputmode="url"
                    :error="form.errors.link"
                    v-model="form.link"
                >
                    <ShareIcon class="inline-block size-4" />
                </InputField>
            </div>
            <div class="mt-5 grid gap-5 sm:mt-6 sm:gap-6">
                <TextArea
                    id="description"
                    name="description"
                    label="Opis"
                    placeholder="Opisz stan, historię i najważniejsze cechy przedmiotu."
                    :required="true"
                    :error="form.errors.description"
                    v-model="form.description"
                >
                    <NewspaperIcon class="inline-block size-4" />
                </TextArea>
            </div>

            <div class="mt-6 grid gap-6">
                <ImageUpload
                    @image="(e) => (form.image = e)"
                    :listingImage="listing.image"
                    :error="form.errors.image"
                />
            </div>

            <div
                class="mt-7 flex flex-col-reverse gap-3 border-t border-slate-200 pt-5 sm:flex-row sm:items-center"
            >
                <Link
                    :href="route('listing.show', listing.id)"
                    class="inline-flex min-h-12 items-center justify-center rounded-lg px-5 text-sm font-semibold text-slate-600 hover:bg-slate-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700"
                >
                    Anuluj
                </Link>
                <PrimaryBtn :loading="form.processing">
                    {{ form.processing ? 'Zapisywanie…' : 'Zapisz zmiany' }}
                </PrimaryBtn>
            </div>
        </form>
    </Container>
</template>

<script setup>
import Container from '@/Components/Container.vue';
import ErrorMessages from '@/Components/ErrorMessages.vue';
import ImageUpload from '@/Components/ImageUpload.vue';
import InputField from '@/Components/InputField.vue';
import PrimaryBtn from '@/Components/PrimaryBtn.vue';
import TextArea from '@/Components/TextArea.vue';
import Title from '@/Components/Title.vue';

const props = defineProps({
    listing: Object,
});

import {
    AtSymbolIcon,
    NewspaperIcon,
    PencilSquareIcon,
    ShareIcon,
    TagIcon,
} from '@heroicons/vue/24/outline';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { nextTick } from 'vue';

const form = useForm({
    title: props.listing.title,
    description: props.listing.description,
    tags: props.listing.tags,
    email: props.listing.email,
    link: props.listing.link,
    image: null,
    _method: 'PUT',
});

const handleSubmit = () => {
    form.post(route('listing.update', props.listing.id), {
        onError: focusFirstError,
    });
};

const focusFirstError = async () => {
    await nextTick();
    document.querySelector('[aria-invalid="true"]')?.focus();
};
</script>
