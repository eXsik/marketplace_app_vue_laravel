<template>
    <div>
        <p class="block text-sm font-semibold text-slate-700">
            Zdjęcie <span class="font-normal text-slate-500">(maks. 3 MB)</span>
        </p>

        <div class="relative mt-2">
            <label
                for="image"
                class="group relative block h-52 cursor-pointer overflow-hidden rounded-xl border border-slate-300 bg-slate-100 text-left transition focus-within:outline focus-within:outline-2 focus-within:outline-offset-2 focus-within:outline-blue-700 hover:border-blue-500 sm:h-60"
            >
                <img
                    :src="preview ?? '/images/listing-placeholder.svg'"
                    alt=""
                    class="h-full w-full object-cover object-center"
                />
                <span
                    class="absolute bottom-3 left-3 inline-flex min-h-11 items-center rounded-lg bg-white/95 px-4 text-sm font-bold text-slate-800 shadow-sm transition group-hover:bg-white"
                >
                    {{ preview ? 'Zmień zdjęcie' : 'Wybierz zdjęcie' }}
                </span>
                <input
                    ref="fileInput"
                    type="file"
                    name="image"
                    id="image"
                    accept="image/jpeg,image/png,image/webp"
                    aria-label="Wybierz zdjęcie do ogłoszenia"
                    class="absolute left-1 top-1 size-px opacity-0"
                    @change="handleImageSelected"
                />
            </label>

            <button
                v-if="showRevertBtn"
                @click="revertImageChange"
                type="button"
                aria-label="Przywróć poprzednie zdjęcie"
                class="absolute right-3 top-3 grid size-11 place-items-center rounded-full bg-white text-slate-800 shadow-md transition hover:bg-slate-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700"
            >
                <ArrowUturnLeftIcon aria-hidden="true" class="size-5" />
            </button>
        </div>

        <p
            v-if="imageError"
            role="alert"
            class="mt-2 text-sm font-medium text-red-700"
        >
            {{ imageError }}
        </p>
        <p
            v-else-if="error"
            role="alert"
            class="mt-2 text-sm font-medium text-red-700"
        >
            {{ error }}
        </p>
        <p v-else class="mt-2 text-xs text-slate-500" aria-live="polite">
            {{
                selectedFileName ||
                'JPG, PNG lub WebP. Możesz zmienić zdjęcie przed zapisaniem.'
            }}
        </p>
    </div>
</template>

<script setup>
import { ArrowUturnLeftIcon } from '@heroicons/vue/24/outline';
import { onBeforeUnmount, ref } from 'vue';
import { listingImageUrl } from '@/utils/listingImage';

const emit = defineEmits(['image']);
const props = defineProps({
    listingImage: String,
    error: String,
});

const currentImage = props.listingImage
    ? listingImageUrl(props.listingImage)
    : null;
const preview = ref(currentImage);
const showRevertBtn = ref(false);
const imageError = ref('');
const selectedFileName = ref('');
const fileInput = ref(null);

const releaseObjectUrl = () => {
    if (preview.value?.startsWith('blob:')) {
        URL.revokeObjectURL(preview.value);
    }
};

const handleImageSelected = (event) => {
    const imageValue = event.target.files?.[0];
    if (!imageValue) return;

    imageError.value = '';
    if (imageValue.size > 3 * 1024 * 1024) {
        imageError.value =
            'To zdjęcie przekracza limit 3 MB. Wybierz mniejszy plik.';
        event.target.value = '';
        releaseObjectUrl();
        preview.value = currentImage;
        showRevertBtn.value = false;
        selectedFileName.value = '';
        emit('image', null);
        return;
    }

    releaseObjectUrl();
    preview.value = URL.createObjectURL(imageValue);
    selectedFileName.value = imageValue.name;
    showRevertBtn.value = true;
    emit('image', imageValue);
};

const revertImageChange = () => {
    releaseObjectUrl();
    preview.value = currentImage;
    showRevertBtn.value = false;
    imageError.value = '';
    selectedFileName.value = '';
    if (fileInput.value) fileInput.value.value = '';
    emit('image', null);
};

onBeforeUnmount(releaseObjectUrl);
</script>
