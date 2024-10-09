<template>
    <div>
        <span
            class="block text-sm font-medium text-slate-700 dark:text-slate-300"
            :class="{ '!text-red-500': oversizedImage }"
        >
            {{
                oversizedImage
                    ? 'The selected image exceeds 3MB'
                    : 'Image (max size 3MB)'
            }}
        </span>

        <label
            for="image"
            class="relative mt-1 block h-40 cursor-pointer overflow-hidden rounded-md border border-slate-300 bg-slate-300"
            :class="{ '!border-red-500': oversizedImage }"
        >
            <img
                :src="preview ?? '/storage/images/listing/default.jpg'"
                class="h-full w-full object-cover object-center"
                alt=""
            />

            <button
                v-if="showRevertBtn"
                @click.prevent="revertImageChange"
                type="button"
                class="absolute right-2 top-2 grid size-8 place-items-center rounded-full bg-white/85 text-slate-700"
            >
                <ArrowUturnLeftIcon class="inline-block size-4" />
            </button>
        </label>

        <input
            type="file"
            name="image"
            id="image"
            hidden
            @input="handleImageSelected"
        />
    </div>
</template>

<script setup>
import { ArrowUturnLeftIcon } from '@heroicons/vue/24/outline';
import { ref } from 'vue';

const emit = defineEmits(['image']);
const props = defineProps({
    listingImage: String,
});

const currentImage = props.listingImage
    ? `/storage/${props.listingImage}`
    : null;

const preview = ref(currentImage);
const oversizedImage = ref(false);
const showRevertBtn = ref(false);

const handleImageSelected = (event) => {
    const imageValue = event.target.files[0];

    preview.value = URL.createObjectURL(imageValue);
    oversizedImage.value = imageValue.size > 3145728;
    showRevertBtn.value = true;
    emit('image', imageValue);
};

const revertImageChange = () => {
    showRevertBtn.value = false;
    preview.value = currentImage;
    oversizedImage.value = false;
    emit('image', null);
};
</script>
