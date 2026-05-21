<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    cita: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Head :title="`Cita #${cita.id}`" />

    <AppLayout :title="`Cita #${cita.id}`">
        <template #header>
            <div class="flex items-center justify-between gap-4">
                <div class="space-y-1">
                    <p class="text-[11px] uppercase tracking-[0.24em] text-slate-500">Inicio / Prestador / Mis citas / Detalle</p>
                    <h2 class="text-base font-semibold text-slate-900">Cita #{{ cita.id }}</h2>
                </div>

                <Link :href="route('prestador.citas.index')" class="rounded-full border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-100">
                    Volver
                </Link>
            </div>
        </template>

        <div class="space-y-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div class="space-y-1">
                        <div class="text-sm font-medium text-slate-900">{{ cita.descripcion }}</div>
                        <div class="text-xs text-slate-500">{{ cita.fecha }}</div>
                    </div>

                    <span :class="cita.cupos_disponibles > 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700'" class="rounded-full px-2.5 py-1 text-[11px] font-medium">
                        {{ cita.cupos_disponibles > 0 ? 'Con cupos' : 'Agotada' }}
                    </span>
                </div>

                <div class="mt-3 grid grid-cols-2 gap-2 text-xs text-slate-600 sm:grid-cols-3">
                    <div class="rounded-xl bg-slate-50 px-3 py-2">
                        <p class="text-[11px] uppercase tracking-[0.18em] text-slate-500">Cupos</p>
                        <p class="mt-1 font-medium text-slate-900">{{ cita.cupos_disponibles }} / {{ cita.cupos_totales }}</p>
                    </div>
                    <div class="rounded-xl bg-slate-50 px-3 py-2">
                        <p class="text-[11px] uppercase tracking-[0.18em] text-slate-500">Solicitantes</p>
                        <p class="mt-1 font-medium text-slate-900">{{ cita.solicitantes.length }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h3 class="text-sm font-semibold text-slate-900">Solicitantes inscritos</h3>
                        <p class="text-xs text-slate-500">Listado compacto de cupos tomados.</p>
                    </div>

                    <span class="rounded-full bg-slate-50 px-2.5 py-1 text-[11px] font-medium text-slate-600">{{ cita.solicitantes.length }}</span>
                </div>

                <div v-if="cita.solicitantes.length" class="mt-4 grid gap-3 md:grid-cols-2">
                    <div v-for="solicitante in cita.solicitantes" :key="solicitante.id" class="rounded-2xl border border-slate-200 p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="space-y-1">
                                <div class="text-sm font-medium text-slate-900">{{ solicitante.name }}</div>
                                <div class="text-xs text-slate-500">{{ solicitante.email }}</div>
                            </div>

                            <span class="rounded-full bg-slate-50 px-2.5 py-1 text-[11px] font-medium text-slate-600">Inscrito</span>
                        </div>
                    </div>
                </div>

                <div v-else class="mt-4 rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-6 text-center">
                    <p class="text-sm font-medium text-slate-900">Todavía no hay solicitantes inscritos.</p>
                    <p class="mt-1 text-xs text-slate-500">Cuando se tomen cupos aparecerán aquí.</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>