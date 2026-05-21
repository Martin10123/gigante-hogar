<script setup>
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const page = usePage();

const userRoles = computed(() => page.props.auth?.user?.roles ?? []);

const hasRole = (roleName) => userRoles.value.some((role) => role.name === roleName);

const featureCards = computed(() => [
    hasRole('Prestador')
        ? {
            tone: 'cyan',
            label: 'Prestador',
            title: 'Crear y gestionar citas',
            description: 'Ve tus citas y revisa inscritos desde el panel.',
        }
        : null,
    hasRole('Solicitante')
        ? {
            tone: 'violet',
            label: 'Solicitante',
            title: 'Suscribirte y reservar',
            description: 'Accede a prestadores y toma cupos disponibles.',
        }
        : null,
].filter(Boolean));

const quickLinks = computed(() => [
    hasRole('Prestador')
        ? { label: 'Mis citas', href: route('prestador.citas.index') }
        : null,
    hasRole('Solicitante')
        ? { label: 'Citas disponibles', href: route('solicitante.citas.index') }
        : null,
    hasRole('Solicitante')
        ? { label: 'Prestadores', href: route('suscripciones.index') }
        : null,
    { label: 'Perfil', href: route('profile.roles.create') },
].filter(Boolean));
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Resumen</p>
                    <h2 class="text-2xl font-bold text-slate-900">Dashboard</h2>
                </div>
                <p class="text-sm text-slate-600">Accesos rápidos al flujo principal.</p>
            </div>
        </template>

        <div class="grid gap-6 lg:grid-cols-3">
            <div
                v-for="card in featureCards"
                :key="card.title"
                class="rounded-3xl border p-6 shadow-sm"
                :class="card.tone === 'cyan' ? 'border-cyan-100 bg-gradient-to-br from-cyan-50 to-white' : 'border-violet-100 bg-gradient-to-br from-violet-50 to-white'"
            >
                <p class="text-sm" :class="card.tone === 'cyan' ? 'text-cyan-700' : 'text-violet-700'">{{ card.label }}</p>
                <h3 class="mt-2 text-xl font-semibold text-slate-900">{{ card.title }}</h3>
                <p class="mt-2 text-sm text-slate-600">{{ card.description }}</p>
            </div>

            <div class="rounded-3xl border border-emerald-100 bg-gradient-to-br from-emerald-50 to-white p-6 shadow-sm">
                <p class="text-sm text-emerald-700">Estado</p>
                <h3 class="mt-2 text-xl font-semibold text-slate-900">Diseño renovado</h3>
                <p class="mt-2 text-sm text-slate-600">Navbar, sidebar y auth con estilo moderno.</p>
            </div>
        </div>

        <div class="mt-6 grid gap-6 lg:grid-cols-2">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Acceso rápido</h3>
                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    <Link v-for="link in quickLinks" :key="link.label" class="rounded-2xl bg-slate-50 px-4 py-3 text-slate-700 hover:bg-slate-100 hover:text-slate-900" :href="link.href">
                        {{ link.label }}
                    </Link>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-gradient-to-br from-slate-50 to-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Inicio sin welcome</h3>
                <p class="mt-2 text-sm text-slate-600">La ruta raíz ahora manda al registro para invitados.</p>
            </div>
        </div>
    </AppLayout>
</template>
