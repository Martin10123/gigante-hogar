<script setup>
import { computed, ref } from 'vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    citas: {
        type: Array,
        default: () => [],
    },
});

const page = usePage();
const search = ref('');
const sortBy = ref('fecha_desc');

const form = useForm({
    descripcion: '',
    fecha: '',
    cupos_totales: 1,
});

const filteredCitas = computed(() => {
    const query = search.value.trim().toLowerCase();
    const items = [...props.citas].filter((cita) => {
        if (!query) {
            return true;
        }

        return [cita.descripcion, cita.fecha, String(cita.cupos_disponibles), String(cita.cupos_totales)]
            .join(' ')
            .toLowerCase()
            .includes(query);
    });

    items.sort((a, b) => {
        if (sortBy.value === 'fecha_asc') {
            return a.fecha.localeCompare(b.fecha);
        }

        if (sortBy.value === 'cupos_asc') {
            return a.cupos_disponibles - b.cupos_disponibles;
        }

        if (sortBy.value === 'cupos_desc') {
            return b.cupos_disponibles - a.cupos_disponibles;
        }

        return b.fecha.localeCompare(a.fecha);
    });

    return items;
});

const submit = () => {
    form.post(route('prestador.citas.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset('descripcion', 'fecha', 'cupos_totales'),
    });
};
</script>

<template>
    <Head title="Mis citas" />

    <AppLayout title="Mis citas">
        <template #header>
            <div class="space-y-1">
                <p class="text-[11px] uppercase tracking-[0.24em] text-slate-500">Inicio / Prestador / Mis citas</p>
                <h2 class="text-base font-semibold text-slate-900">Mis citas</h2>
                <p class="text-xs text-slate-500">Crea citas futuras y revisa quién tomó cupo.</p>
            </div>
        </template>

        <div class="space-y-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h3 class="text-sm font-semibold text-slate-900">Crear cita</h3>
                        <p class="text-xs text-slate-500">Solo fechas futuras y cupos definidos.</p>
                    </div>

                    <p v-if="page.props.flash?.status" class="rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-medium text-emerald-700">
                        {{ page.props.flash.status }}
                    </p>
                </div>

                <div class="mt-4 grid gap-3 md:grid-cols-3">
                    <div>
                        <InputLabel value="Descripción" class="text-xs uppercase tracking-[0.18em] text-slate-500" />
                        <TextInput v-model="form.descripcion" type="text" class="mt-1 block w-full text-sm" />
                        <InputError class="mt-1" :message="form.errors.descripcion" />
                    </div>

                    <div>
                        <InputLabel value="Fecha" class="text-xs uppercase tracking-[0.18em] text-slate-500" />
                        <TextInput v-model="form.fecha" type="date" class="mt-1 block w-full text-sm" />
                        <InputError class="mt-1" :message="form.errors.fecha" />
                    </div>

                    <div>
                        <InputLabel value="Cupos totales" class="text-xs uppercase tracking-[0.18em] text-slate-500" />
                        <TextInput v-model="form.cupos_totales" type="number" min="1" class="mt-1 block w-full text-sm" />
                        <InputError class="mt-1" :message="form.errors.cupos_totales" />
                    </div>
                </div>

                <div class="mt-4 flex items-center gap-3">
                    <PrimaryButton class="!text-xs" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click.prevent="submit">
                        {{ form.processing ? 'Creando...' : 'Crear cita' }}
                    </PrimaryButton>

                    <p class="text-xs text-slate-500">La cita se publica de inmediato.</p>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h3 class="text-sm font-semibold text-slate-900">Citas registradas</h3>
                        <p class="text-xs text-slate-500">Ordena, busca y abre el detalle de inscritos.</p>
                    </div>

                    <div class="flex gap-2">
                        <TextInput v-model="search" type="search" placeholder="Buscar cita" class="w-full text-sm sm:w-56" />
                        <select v-model="sortBy" class="rounded-xl border-slate-200 text-sm text-slate-700 focus:border-slate-400 focus:ring-slate-400">
                            <option value="fecha_desc">Más recientes</option>
                            <option value="fecha_asc">Más antiguas</option>
                            <option value="cupos_desc">Más cupos</option>
                            <option value="cupos_asc">Menos cupos</option>
                        </select>
                    </div>
                </div>

                <div v-if="filteredCitas.length" class="mt-4 grid gap-3 lg:grid-cols-2">
                    <div v-for="cita in filteredCitas" :key="cita.id" class="rounded-2xl border border-slate-200 p-4">
                        <div class="flex items-start justify-between gap-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <div class="text-sm font-medium text-slate-900">{{ cita.descripcion }}</div>
                                    <span :class="cita.cupos_disponibles > 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700'" class="rounded-full px-2 py-0.5 text-[11px] font-medium">
                                        {{ cita.cupos_disponibles > 0 ? 'Disponible' : 'Agotada' }}
                                    </span>
                                </div>
                                <div class="text-xs text-slate-500">{{ cita.fecha }}</div>
                            </div>

                            <Link :href="route('prestador.citas.show', cita.id)" class="rounded-full border border-slate-200 px-3 py-1.5 text-[11px] font-medium text-slate-700 hover:bg-slate-100">
                                Ver inscritos
                            </Link>
                        </div>

                        <div class="mt-3 grid grid-cols-2 gap-2 text-xs text-slate-600">
                            <div class="rounded-xl bg-slate-50 px-3 py-2">
                                <p class="text-[11px] uppercase tracking-[0.18em] text-slate-500">Cupos</p>
                                <p class="mt-1 font-medium text-slate-900">{{ cita.cupos_disponibles }} / {{ cita.cupos_totales }}</p>
                            </div>
                            <div class="rounded-xl bg-slate-50 px-3 py-2">
                                <p class="text-[11px] uppercase tracking-[0.18em] text-slate-500">Inscritos</p>
                                <p class="mt-1 font-medium text-slate-900">{{ cita.cupos_count }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else class="mt-4 rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-6 text-center">
                    <p class="text-sm font-medium text-slate-900">No hay citas para mostrar.</p>
                    <p class="mt-1 text-xs text-slate-500">Prueba cambiando el filtro o crea una nueva cita.</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>