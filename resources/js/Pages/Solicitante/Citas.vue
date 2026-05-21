<script setup>
import { computed, ref } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    availableCitas: {
        type: Array,
        default: () => [],
    },
    myCupos: {
        type: Array,
        default: () => [],
    },
});

const page = usePage();
const search = ref('');
const sortBy = ref('fecha_asc');

const form = useForm({});

const filteredAvailableCitas = computed(() => {
    const query = search.value.trim().toLowerCase();
    const items = [...props.availableCitas].filter((cita) => {
        if (!query) {
            return true;
        }

        return [cita.descripcion, cita.fecha, cita.prestador?.name, String(cita.cupos_disponibles)]
            .join(' ')
            .toLowerCase()
            .includes(query);
    });

    items.sort((a, b) => {
        if (sortBy.value === 'cupos_desc') {
            return b.cupos_disponibles - a.cupos_disponibles;
        }

        if (sortBy.value === 'cupos_asc') {
            return a.cupos_disponibles - b.cupos_disponibles;
        }

        if (sortBy.value === 'fecha_desc') {
            return b.fecha.localeCompare(a.fecha);
        }

        return a.fecha.localeCompare(b.fecha);
    });

    return items;
});

const sortedMyCupos = computed(() => [...props.myCupos].sort((a, b) => b.fecha.localeCompare(a.fecha)));

const reserve = (citaId) => {
    form.post(route('solicitante.cupos.store', citaId), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Citas disponibles" />

    <AppLayout title="Citas disponibles">
        <template #header>
            <div class="space-y-1">
                <p class="text-[11px] uppercase tracking-[0.24em] text-slate-500">Inicio / Solicitante / Citas</p>
                <h2 class="text-base font-semibold text-slate-900">Citas disponibles</h2>
                <p class="text-xs text-slate-500">Busca, ordena y reserva en una interfaz compacta.</p>
            </div>
        </template>

        <div class="space-y-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h3 class="text-sm font-semibold text-slate-900">Mis cupos</h3>
                        <p class="text-xs text-slate-500">Reservas confirmadas.</p>
                    </div>

                    <span class="rounded-full bg-slate-50 px-2.5 py-1 text-[11px] font-medium text-slate-600">{{ sortedMyCupos.length }}</span>
                </div>

                <div v-if="sortedMyCupos.length" class="mt-4 grid gap-3 md:grid-cols-2">
                    <div v-for="cupo in sortedMyCupos" :key="cupo.id" class="rounded-2xl border border-slate-200 p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="space-y-1">
                                <div class="text-sm font-medium text-slate-900">{{ cupo.descripcion }}</div>
                                <div class="text-xs text-slate-500">{{ cupo.fecha }}</div>
                            </div>

                            <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-medium text-emerald-700">Confirmado</span>
                        </div>
                        <div class="mt-3 text-xs text-slate-500">Prestador: {{ cupo.prestador }}</div>
                    </div>
                </div>

                <div v-else class="mt-4 rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-6 text-center">
                    <p class="text-sm font-medium text-slate-900">Todavía no has tomado cupos.</p>
                    <p class="mt-1 text-xs text-slate-500">Cuando reserves uno, aparecerá aquí.</p>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h3 class="text-sm font-semibold text-slate-900">Citas disponibles</h3>
                        <p class="text-xs text-slate-500">Solo aparecen prestadores a los que ya te suscribiste.</p>
                    </div>

                    <div class="flex gap-2">
                        <input v-model="search" type="search" placeholder="Buscar cita" class="w-full rounded-xl border-slate-200 text-sm text-slate-700 focus:border-slate-400 focus:ring-slate-400 sm:w-56" />
                        <select v-model="sortBy" class="rounded-xl border-slate-200 text-sm text-slate-700 focus:border-slate-400 focus:ring-slate-400">
                            <option value="fecha_asc">Fecha asc</option>
                            <option value="fecha_desc">Fecha desc</option>
                            <option value="cupos_desc">Más cupos</option>
                            <option value="cupos_asc">Menos cupos</option>
                        </select>
                    </div>
                </div>

                <p v-if="page.props.flash?.status" class="mt-3 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-medium text-emerald-700">
                    {{ page.props.flash.status }}
                </p>
                <p v-if="form.errors.cita" class="mt-3 rounded-full bg-rose-50 px-3 py-1.5 text-xs font-medium text-rose-700">
                    {{ form.errors.cita }}
                </p>

                <div v-if="filteredAvailableCitas.length" class="mt-4 grid gap-3 lg:grid-cols-2">
                    <div v-for="cita in filteredAvailableCitas" :key="cita.id" class="rounded-2xl border border-slate-200 p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <div class="text-sm font-medium text-slate-900">{{ cita.descripcion }}</div>
                                    <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-medium text-emerald-700">Disponible</span>
                                </div>
                                <div class="text-xs text-slate-500">{{ cita.fecha }}</div>
                                <div class="text-xs text-slate-500">Prestador: {{ cita.prestador.name }}</div>
                            </div>

                            <PrimaryButton class="!text-xs" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click.prevent="reserve(cita.id)">
                                {{ form.processing ? 'Tomando...' : 'Tomar cupo' }}
                            </PrimaryButton>
                        </div>

                        <div class="mt-3 grid grid-cols-2 gap-2 text-xs text-slate-600">
                            <div class="rounded-xl bg-slate-50 px-3 py-2">
                                <p class="text-[11px] uppercase tracking-[0.18em] text-slate-500">Disponibles</p>
                                <p class="mt-1 font-medium text-slate-900">{{ cita.cupos_disponibles }} / {{ cita.cupos_totales }}</p>
                            </div>
                            <div class="rounded-xl bg-slate-50 px-3 py-2">
                                <p class="text-[11px] uppercase tracking-[0.18em] text-slate-500">Prestador</p>
                                <p class="mt-1 font-medium text-slate-900">{{ cita.prestador.name }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else class="mt-4 rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-6 text-center">
                    <p class="text-sm font-medium text-slate-900">No hay citas disponibles.</p>
                    <p class="mt-1 text-xs text-slate-500">Suscríbete a un prestador para ver sus citas activas.</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>