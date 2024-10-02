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
            <NavLink routeName="home" componentName="Home">Home</NavLink>

            <div class="flex items-center space-x-6">
                <NavLink routeName="login" componentName="Auth/Login">
                    Login
                </NavLink>
                <NavLink routeName="register" componentName="Auth/Register">
                    Register
                </NavLink>

                <button
                    @click="toggleDark()"
                    class="grid size-6 place-items-center rounded-full outline-none hover:bg-slate-700"
                >
                    <span v-if="isDark" class="size-5">
                        <SunIcon />
                    </span>
                    <span v-else class="size-5">
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
