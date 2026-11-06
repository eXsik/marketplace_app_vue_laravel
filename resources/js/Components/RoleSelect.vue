<template>
    <div class="flex items-center gap-2">
        <form class="flex items-center gap-2" @change="handleChangeRole">
            <label :for="`role-${user.id}`" class="sr-only">
                Rola użytkownika {{ user.name }}
            </label>
            <select
                :id="`role-${user.id}`"
                v-model="form.role"
                :name="`role-${user.id}`"
                class="block min-h-11 w-full rounded-lg border border-slate-300 bg-white px-3 text-sm text-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-700"
            >
                <option value="admin">Administrator</option>
                <option value="general">Użytkownik</option>
                <option value="suspended">Zawieszony</option>
            </select>
        </form>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    user: Object,
});

const form = useForm({
    role: props.user.role,
});

const handleChangeRole = () => {
    if (confirm(`Zmienić rolę użytkownika na ${roleLabel(form.role)}?`)) {
        form.put(route('admin.role', props.user.id));
    } else {
        form.role = props.user.role;
    }
};

const roleLabel = (role) =>
    ({
        admin: 'administrator',
        general: 'użytkownik',
        suspended: 'zawieszony',
    })[role] ?? role;
</script>
