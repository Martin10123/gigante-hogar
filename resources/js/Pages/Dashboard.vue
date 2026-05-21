<script setup>
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    stats: {
        type: Object,
        required: true,
    },
});

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

const statCards = computed(() => [
    {
        label: 'Citas creadas',
        value: props.stats.citas_creadas ?? 0,
        note: 'Como prestador',
    },
    {
        label: 'Prestadores suscritos',
        value: props.stats.prestadores_suscritos ?? 0,
        note: 'Como solicitante',
    },
    {
        label: 'Cupos tomados',
        value: props.stats.cupos_tomados ?? 0,
        note: 'Reservas activas',
    },
] );
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div class="space-y-1">
                    <p class="text-[11px] uppercase tracking-[0.24em] text-slate-500">Inicio / Dashboard</p>
                    <h2 class="text-base font-semibold text-slate-900">Resumen operativo</h2>
                    <p class="text-xs text-slate-500">Accesos rápidos y métricas del flujo principal.</p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <span
                        v-for="role in userRoles"
                        :key="role.id"
                        class="rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 text-[11px] font-medium text-slate-600"
                    >
                        {{ role.name }}
                    </span>
                </div>
            </div>
        </template>

        <div class="grid gap-4 md:grid-cols-3">
            <div
                v-for="card in statCards"
                :key="card.label"
                class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm"
            >
                <p class="text-[11px] uppercase tracking-[0.2em] text-slate-500">{{ card.label }}</p>
                <div class="mt-2 flex items-end justify-between gap-4">
                    <div class="text-2xl font-semibold text-slate-900">{{ card.value }}</div>
                    <p class="text-xs text-slate-500">{{ card.note }}</p>
                </div>
            </div>
        </div>

        <div v-if="featureCards.length" class="mt-4 grid gap-4 md:grid-cols-2">
            <div
                v-for="card in featureCards"
                :key="card.title"
                class="rounded-2xl border bg-white p-4 shadow-sm"
                :class="card.tone === 'cyan' ? 'border-cyan-100' : 'border-violet-100'"
            >
                <p class="text-[11px] uppercase tracking-[0.2em]" :class="card.tone === 'cyan' ? 'text-cyan-700' : 'text-violet-700'">{{ card.label }}</p>
                <h3 class="mt-2 text-sm font-semibold text-slate-900">{{ card.title }}</h3>
                <p class="mt-1 text-xs text-slate-600">{{ card.description }}</p>
            </div>
        </div>

        <div class="mt-4 grid gap-4 lg:grid-cols-2">
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <h3 class="text-sm font-semibold text-slate-900">Acceso rápido</h3>
                <div class="mt-3 grid gap-2 sm:grid-cols-2">
                    <Link v-for="link in quickLinks" :key="link.label" class="rounded-2xl bg-slate-50 px-4 py-3 text-slate-700 hover:bg-slate-100 hover:text-slate-900" :href="link.href">
                        {{ link.label }}
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
