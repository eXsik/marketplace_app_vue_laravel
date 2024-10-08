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
            class="mt-1 block h-40 cursor-pointer overflow-hidden rounded-md border border-slate-300 bg-slate-300"
            :class="{ '!border-red-500': oversizedImage }"
        >
            <img
                :src="preview ?? '/storage/images/listing/default.jpg'"
                class="h-full w-full object-cover object-center"
                alt=""
            />
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
import { ref } from 'vue';

const emit = defineEmits(['image']);

const preview = ref(null);
const oversizedImage = ref(false);

const handleImageSelected = (event) => {
    const imageValue = event.target.files[0];

    preview.value = URL.createObjectURL(imageValue);
    oversizedImage.value = imageValue.size > 3145728;
    emit('image', imageValue);
};
</script>
