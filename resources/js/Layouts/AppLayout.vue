<script setup>
import { computed, ref } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import Banner from '@/Components/Banner.vue';
import Button from 'primevue/button';
import Sidebar from 'primevue/sidebar';

defineProps({
    title: String,
});

const page = usePage();
const showSidebar = ref(false);

const userName = computed(() => page.props.auth?.user?.name ?? 'Usuario');

const userRoles = computed(() => page.props.auth?.user?.roles ?? []);

const hasRole = (roleName) => userRoles.value.some((role) => role.name === roleName);

const navigationItems = [
    { label: 'Dashboard', href: route('dashboard'), match: 'dashboard' },
    { label: 'Perfil', href: route('profile.roles.create'), match: 'profile.roles.create' },
    { label: 'Prestadores', href: route('suscripciones.index'), match: 'suscripciones.index', roles: ['Solicitante'] },
    { label: 'Mis citas', href: route('prestador.citas.index'), match: 'prestador.citas.index', roles: ['Prestador'] },
    { label: 'Citas disponibles', href: route('solicitante.citas.index'), match: 'solicitante.citas.index', roles: ['Solicitante'] },
];

const visibleNavigationItems = computed(() => navigationItems.filter((item) => !item.roles || item.roles.some((roleName) => hasRole(roleName))));

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div>
        <Head :title="title" />
        <Banner />

        <div class="min-h-screen bg-slate-50 text-slate-900">
            <Sidebar v-model:visible="showSidebar" class="w-[16rem] bg-white text-slate-900 lg:hidden" dismissable>
                <div class="flex items-center gap-2.5 border-b border-slate-200 pb-4">
                    <div class="grid h-9 w-9 place-items-center rounded-xl bg-slate-100 text-slate-700 text-xs font-semibold">GC</div>
                    <div>
                        <p class="text-[11px] uppercase tracking-[0.18em] text-slate-500">Sistema de citas</p>
                        <h1 class="text-sm font-semibold text-slate-900">Gigante del Hogar</h1>
                    </div>
                </div>

                <div class="mt-4 space-y-1.5">
                    <Link
                        v-for="item in visibleNavigationItems"
                        :key="item.label"
                        :href="item.href"
                        class="block rounded-xl px-3.5 py-2.5 text-[13px] font-medium transition"
                        :class="route().current(item.match) ? 'bg-slate-100 text-slate-900 ring-1 ring-slate-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'"
                        @click="showSidebar = false"
                    >
                        {{ item.label }}
                    </Link>
                </div>
            </Sidebar>

            <div class="flex min-h-screen">
                <aside class="hidden lg:flex w-64 flex-col border-r border-slate-200 bg-white backdrop-blur-xl">
                    <div class="flex items-center gap-2.5 border-b border-slate-200 px-5 py-5">
                        <div class="grid h-9 w-9 place-items-center rounded-xl bg-slate-100 text-slate-700 text-xs font-semibold">GC</div>
                        <div>
                            <p class="text-[11px] uppercase tracking-[0.18em] text-slate-500">Sistema de citas</p>
                            <h1 class="text-sm font-semibold text-slate-900">Gigante del Hogar</h1>
                        </div>
                    </div>

                    <div class="px-3 py-3">
                        <p class="px-2 text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">Navegación</p>
                        <div class="mt-2.5 space-y-1.5">
                            <Link
                                v-for="item in visibleNavigationItems"
                                :key="item.label"
                                :href="item.href"
                                class="block rounded-xl px-3.5 py-2.5 text-[13px] font-medium transition"
                                :class="route().current(item.match) ? 'bg-slate-100 text-slate-900 ring-1 ring-slate-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900'"
                            >
                                {{ item.label }}
                            </Link>
                        </div>
                    </div>

                    <div class="mt-auto p-3">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3">
                            <p class="text-sm font-semibold text-slate-900">{{ userName }}</p>
                            <p class="text-[12px] text-slate-500">Sesión activa</p>
                        </div>
                    </div>
                </aside>

                <div class="flex min-w-0 flex-1 flex-col">
                    <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/90 backdrop-blur-xl">
                        <div class="flex items-center justify-between px-4 py-3 sm:px-5 lg:px-6">
                            <div class="flex items-center gap-3">
                                <button class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm lg:hidden" @click="showSidebar = true">☰</button>
                                <div>
                                    <p class="text-[11px] uppercase tracking-[0.25em] text-slate-400">Panel</p>
                                    <h2 class="text-base font-semibold text-slate-900">{{ title }}</h2>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <Button severity="danger" outlined class="!rounded-2xl" label="Salir" @click="logout" />
                            </div>
                        </div>
                    </header>

                    <main class="flex-1 px-4 py-5 sm:px-5 lg:px-6">
                        <div v-if="$slots.header" class="mb-4 rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm">
                            <slot name="header" />
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
                            <slot />
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>
</template>
