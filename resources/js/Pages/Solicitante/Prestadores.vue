<script setup>
import { computed, ref } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    availablePrestadores: {
        type: Array,
        default: () => [],
    },
    subscribedPrestadores: {
        type: Array,
        default: () => [],
    },
});

const page = usePage();
const search = ref('');
const sortBy = ref('name_asc');

const form = useForm({
    prestador_id: '',
});

const sortItems = (items) => {
    const sorted = [...items];

    sorted.sort((a, b) => {
        const nameCompare = a.name.localeCompare(b.name);
        return sortBy.value === 'name_desc' ? -nameCompare : nameCompare;
    });

    return sorted;
};

const filterItems = (items) => {
    const query = search.value.trim().toLowerCase();

    return sortItems(items.filter((item) => {
        if (!query) {
            return true;
        }

        return [item.name, item.email].join(' ').toLowerCase().includes(query);
    }));
};

const filteredSubscribedPrestadores = computed(() => filterItems(props.subscribedPrestadores));
const filteredAvailablePrestadores = computed(() => filterItems(props.availablePrestadores));

const subscribe = (prestadorId) => {
    form.prestador_id = prestadorId;
    form.post(route('suscripciones.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset('prestador_id'),
    });
};
</script>

<template>
    <Head title="Prestadores" />

    <AppLayout title="Prestadores">
        <template #header>
            <div class="space-y-1">
                <p class="text-[11px] uppercase tracking-[0.24em] text-slate-500">Inicio / Solicitante / Prestadores</p>
                <h2 class="text-base font-semibold text-slate-900">Prestadores</h2>
                <p class="text-xs text-slate-500">Busca y suscríbete a prestadores activos.</p>
            </div>
        </template>

        <div class="space-y-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h3 class="text-sm font-semibold text-slate-900">Prestadores suscritos</h3>
                        <p class="text-xs text-slate-500">Tus accesos activos.</p>
                    </div>

                    <div class="flex gap-2">
                        <input v-model="search" type="search" placeholder="Buscar prestador" class="w-full rounded-xl border-slate-200 text-sm text-slate-700 focus:border-slate-400 focus:ring-slate-400 sm:w-56" />
                        <select v-model="sortBy" class="rounded-xl border-slate-200 text-sm text-slate-700 focus:border-slate-400 focus:ring-slate-400">
                            <option value="name_asc">Nombre A-Z</option>
                            <option value="name_desc">Nombre Z-A</option>
                        </select>
                    </div>
                </div>

                <p v-if="page.props.flash?.status" class="mt-3 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-medium text-emerald-700">
                    {{ page.props.flash.status }}
                </p>
                <InputError class="mt-3" :message="form.errors.prestador_id" />

                <div v-if="filteredSubscribedPrestadores.length" class="mt-4 grid gap-3 md:grid-cols-2">
                    <div v-for="prestador in filteredSubscribedPrestadores" :key="prestador.id" class="rounded-2xl border border-slate-200 p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="space-y-1">
                                <div class="text-sm font-medium text-slate-900">{{ prestador.name }}</div>
                                <div class="text-xs text-slate-500">{{ prestador.email }}</div>
                            </div>

                            <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-medium text-emerald-700">Suscrito</span>
                        </div>
                    </div>
                </div>

                <div v-else class="mt-4 rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-6 text-center">
                    <p class="text-sm font-medium text-slate-900">Todavía no tienes prestadores suscritos.</p>
                    <p class="mt-1 text-xs text-slate-500">Suscríbete a uno para ver sus citas.</p>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h3 class="text-sm font-semibold text-slate-900">Prestadores disponibles</h3>
                        <p class="text-xs text-slate-500">Busca y suscríbete en un paso.</p>
                    </div>

                    <span class="rounded-full bg-slate-50 px-2.5 py-1 text-[11px] font-medium text-slate-600">{{ filteredAvailablePrestadores.length }}</span>
                </div>

                <div v-if="filteredAvailablePrestadores.length" class="mt-4 grid gap-3 md:grid-cols-2">
                    <div v-for="prestador in filteredAvailablePrestadores" :key="prestador.id" class="flex items-center justify-between gap-4 rounded-2xl border border-slate-200 p-4">
                        <div class="space-y-1">
                            <div class="text-sm font-medium text-slate-900">{{ prestador.name }}</div>
                            <div class="text-xs text-slate-500">{{ prestador.email }}</div>
                        </div>

                        <PrimaryButton class="!text-xs" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click.prevent="subscribe(prestador.id)">
                            {{ form.processing ? 'Suscribiendo...' : 'Suscribirme' }}
                        </PrimaryButton>
                    </div>
                </div>

                <div v-else class="mt-4 rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-6 text-center">
                    <p class="text-sm font-medium text-slate-900">No hay prestadores disponibles para suscribirse.</p>
                    <p class="mt-1 text-xs text-slate-500">Prueba con otro filtro o revisa si ya estás suscrito a todos.</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>