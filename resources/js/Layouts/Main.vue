<script setup>
import { MoonIcon, SunIcon } from '@heroicons/vue/24/outline';
import { useDark, useToggle } from '@vueuse/core';
import NavLink from '@/Components/NavLink.vue';

const isDark = useDark();
const toggleDark = useToggle(isDark);
</script>

<template>
    <header class="bg-slate-800 text-white">
        <nav
            class="mx-auto flex max-w-screen-lg items-center justify-between p-6"
        >
            <NavLink routeName="home">Home</NavLink>

            <div>
                <button
                    @click="toggleDark()"
                    class="grid size-6 place-items-center rounded-full outline-none hover:bg-slate-700"
                >
                    <span v-if="isDark" class="size-6">
                        <SunIcon />
                    </span>
                    <span v-else class="size-6">
                        <MoonIcon />
                    </span>
                </button>
            </div>
        </nav>
    </header>

    <main class="mx-auto max-w-screen-lg p-6">
        <slot />
    </main>
</template>
