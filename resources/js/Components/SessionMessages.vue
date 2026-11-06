<template>
    <div
        v-if="status"
        role="status"
        aria-live="polite"
        class="rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-emerald-900"
    >
        <div class="flex items-start gap-3">
            <CheckCircleIcon class="mt-0.5 size-5 shrink-0 text-emerald-700" />
            <p class="text-sm font-medium">{{ message }}</p>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { CheckCircleIcon } from '@heroicons/vue/24/outline';

const props = defineProps({ status: String });

const message = computed(() => {
    const translations = {
        'Listing created successfully.': 'Ogłoszenie zostało dodane.',
        'Listing updated successfully.': 'Ogłoszenie zostało zaktualizowane.',
        'Listing deleted successfully.': 'Ogłoszenie zostało usunięte.',
        'Profile updated successfully.': 'Profil został zaktualizowany.',
        'Password updated successfully.': 'Hasło zostało zmienione.',
        'Verification link sent!': 'Wysłaliśmy nowy link weryfikacyjny.',
    };

    if (translations[props.status]) return translations[props.status];

    const roleChange = props.status?.match(
        /^User role changed to (.+) successfully$/,
    );
    if (roleChange)
        return `Rola użytkownika została zmieniona na: ${roleChange[1]}.`;

    const listingStatus = props.status?.match(
        /^Listing (approved|disapproved) successfully!?$/,
    );
    if (listingStatus) {
        return listingStatus[1] === 'approved'
            ? 'Ogłoszenie zostało zaakceptowane.'
            : 'Ogłoszenie zostało odrzucone.';
    }

    return props.status;
});
</script>
