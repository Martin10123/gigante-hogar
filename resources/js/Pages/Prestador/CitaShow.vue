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
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Cita #{{ cita.id }}
                </h2>

                <Link :href="route('prestador.citas.index')" class="text-sm text-indigo-600 hover:text-indigo-800">
                    Volver
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 space-y-2">
                    <div class="font-medium text-gray-900 text-lg">{{ cita.descripcion }}</div>
                    <div class="text-sm text-gray-500">{{ cita.fecha }}</div>
                    <div class="text-sm text-gray-600">Cupos: {{ cita.cupos_disponibles }} / {{ cita.cupos_totales }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Solicitantes inscritos</h3>

                    <div v-if="cita.solicitantes.length" class="grid gap-3 md:grid-cols-2">
                        <div v-for="solicitante in cita.solicitantes" :key="solicitante.id" class="border rounded-lg p-4">
                            <div class="font-medium text-gray-900">{{ solicitante.name }}</div>
                            <div class="text-sm text-gray-500">{{ solicitante.email }}</div>
                        </div>
                    </div>

                    <p v-else class="text-sm text-gray-500">Todavía no hay solicitantes inscritos.</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>