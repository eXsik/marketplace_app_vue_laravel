<template>
    <Head title="- Edit Listing" />
    <Container>
        <div class="mb-6">
            <Title>Edit #{{ listing.id }} listing</Title>
        </div>

        <ErrorMessages :errors="form.errors" />

        <form @submit.prevent="handleSubmit">
            <div class="grid grid-cols-2 gap-6">
                <InputField
                    label="Title"
                    placeholder="My new listing"
                    v-model="form.title"
                >
                    <PencilSquareIcon class="inline-block size-4" />
                </InputField>

                <InputField
                    label="Tags (separate with comma)"
                    placeholder="one, two, three"
                    v-model="form.tags"
                >
                    <TagIcon class="inline-block size-4" />
                </InputField>
            </div>

            <div class="mt-6 grid grid-cols-2 gap-6">
                <InputField
                    label="Email"
                    placeholder="example@email.com"
                    v-model="form.email"
                >
                    <AtSymbolIcon class="inline-block size-4" />
                </InputField>

                <InputField
                    label="External Link"
                    placeholder="https://example.com"
                    v-model="form.link"
                >
                    <ShareIcon class="inline-block size-4" />
                </InputField>
            </div>
            <div class="mt-6 grid gap-6">
                <TextArea
                    label="Description"
                    placeholder="This is my listing description"
                    v-model="form.description"
                >
                    <NewspaperIcon class="inline-block size-4" />
                </TextArea>
            </div>

            <div class="mt-6 grid gap-6">
                <ImageUpload
                    @image="(e) => (form.image = e)"
                    :listingImage="listing.image"
                />
            </div>

            <div class="mt-6">
                <PrimaryBtn :disabled="form.processing">Update</PrimaryBtn>
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
import { Head, useForm } from '@inertiajs/vue3';

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
    form.post(route('listing.update', props.listing.id));
};
</script>
