<script setup>
import { ChevronDownIcon, PlusIcon } from '@heroicons/vue/24/outline';
import { usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const page = usePage();
const user = computed(() => page.props.auth.user);
const menuOpen = ref(false);
</script>

<template>
    <div class="app-shell">
        <header class="site-header">
            <nav class="site-nav" aria-label="Główna nawigacja">
                <Link :href="route('home')" class="brand-mark">
                    <span class="brand-symbol" aria-hidden="true">p</span>
                    <span>po<span class="brand-accent">sąsiedzku</span></span>
                </Link>

                <div class="desktop-nav-links">
                    <Link :href="route('home')" class="nav-browse"
                        >Przeglądaj</Link
                    >
                    <Link
                        v-if="user"
                        :href="route('dashboard')"
                        class="nav-browse"
                    >
                        Moje ogłoszenia
                    </Link>
                </div>

                <div class="nav-actions">
                    <Link
                        v-if="user"
                        :href="route('listing.create')"
                        class="nav-create"
                    >
                        <PlusIcon class="size-4" />
                        <span>Dodaj ogłoszenie</span>
                    </Link>
                    <div v-if="user" class="account-menu-wrap">
                        <button
                            class="account-button"
                            :aria-expanded="menuOpen"
                            aria-label="Otwórz menu konta"
                            @click="menuOpen = !menuOpen"
                        >
                            <span class="account-avatar">
                                {{ user.name.slice(0, 1).toUpperCase() }}
                            </span>
                            <ChevronDownIcon class="size-4" />
                        </button>
                        <div v-if="menuOpen" class="account-menu">
                            <p class="account-name">{{ user.name }}</p>
                            <Link :href="route('profile.edit')">Profil</Link>
                            <Link :href="route('dashboard')">Panel</Link>
                            <Link
                                v-if="user.role === 'admin'"
                                :href="route('admin.index')"
                            >
                                Administracja
                            </Link>
                            <Link
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Wyloguj się
                            </Link>
                        </div>
                    </div>
                    <template v-else>
                        <Link :href="route('login')" class="nav-login"
                            >Zaloguj się</Link
                        >
                        <Link :href="route('register')" class="nav-create">
                            Załóż konto
                        </Link>
                    </template>
                </div>
            </nav>
        </header>

        <main class="page-container">
            <slot />
        </main>

        <footer class="site-footer">
            <div class="site-footer-inner">
                <Link :href="route('home')" class="brand-mark footer-brand">
                    <span class="brand-symbol" aria-hidden="true">p</span>
                    <span>po<span class="brand-accent">sąsiedzku</span></span>
                </Link>
                <p>Rzeczy z drugiego obiegu. Historie z pierwszej ręki.</p>
            </div>
        </footer>
    </div>
</template>
