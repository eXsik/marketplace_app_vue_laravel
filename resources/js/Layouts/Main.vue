<script setup>
import { ChevronDownIcon, MoonIcon, SunIcon } from '@heroicons/vue/24/outline';
import { useDark, useToggle } from '@vueuse/core';
import NavLink from '@/Components/NavLink.vue';
import { usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const isDark = useDark();
const toggleDark = useToggle(isDark);
const page = usePage();
const user = computed(() => page.props.auth.user);

const show = ref(false);
</script>

<template>
    <!-- Work around for the click outside modifier -->
    <div v-show="show" @click="show = false" class="fixed inset-0 z-40"></div>
    <header class="bg-slate-800 text-white">
        <nav
            class="mx-auto flex max-w-screen-lg items-center justify-between p-6"
        >
            <NavLink routeName="home" componentName="Home">Home</NavLink>

            <div class="flex items-center space-x-6">
                <div v-if="user" class="relative">
                    <div
                        class="flex cursor-pointer items-center gap-2 rounded-lg px-3 py-1 hover:bg-slate-700"
                        :class="{ 'bg-slate-700': show }"
                        @click="show = !show"
                    >
                        <p>{{ user.name }}</p>
                        <ChevronDownIcon class="size-4" />
                    </div>

                    <div
                        v-show="show"
                        @click="show = false"
                        class="absolute right-0 top-10 z-50 w-40 overflow-hidden rounded-lg bg-slate-800 text-white"
                    >
                        <Link
                            :href="route('profile.edit')"
                            class="block w-full px-6 py-3 text-left hover:bg-slate-700"
                        >
                            Profile
                        </Link>

                        <Link
                            :href="route('dashboard')"
                            class="block w-full px-6 py-3 text-left hover:bg-slate-700"
                        >
                            Dashboard
                        </Link>

                        <Link
                            :href="route('logout')"
                            method="post"
                            as="button"
                            class="block w-full px-6 py-3 text-left hover:bg-slate-700"
                        >
                            Logout
                        </Link>
                    </div>
                </div>

                <div v-else class="space-x-4">
                    <NavLink routeName="login" componentName="Auth/Login">
                        Login
                    </NavLink>
                    <NavLink routeName="register" componentName="Auth/Register">
                        Register
                    </NavLink>
                </div>

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
