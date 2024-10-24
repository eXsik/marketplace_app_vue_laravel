<template>
    <div class="flex items-center gap-2">
        <form class="flex items-center gap-2" @change="handleChangeRole">
            <label for="roles" class="sr-only">Roles:</label>
            <select
                v-model="form.role"
                name="roles"
                class="block w-full rounded border border-gray-300 bg-gray-50 px-2 py-1 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
            >
                <option value="admin" class="text-slate-800 dark:text-white">
                    Admin
                </option>
                <option value="general" class="text-slate-800 dark:text-white">
                    General
                </option>
                <option
                    value="suspended"
                    class="text-slate-800 dark:text-white"
                >
                    Suspended
                </option>
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
    if (confirm(`Change this user's role to ${form.role}`)) {
        form.put(route('admin.role', props.user.id));
    } else {
        form.role = props.user.role;
    }
};
</script>
