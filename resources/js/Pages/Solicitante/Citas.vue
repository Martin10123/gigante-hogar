<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    availableCitas: {
        type: Array,
        default: () => [],
    },
    myCupos: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({});

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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Citas disponibles
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Mis cupos</h3>

                    <div v-if="myCupos.length" class="grid gap-3 md:grid-cols-2">
                        <div v-for="cupo in myCupos" :key="cupo.id" class="border rounded-lg p-4">
                            <div class="font-medium text-gray-900">{{ cupo.descripcion }}</div>
                            <div class="text-sm text-gray-500">{{ cupo.fecha }}</div>
                            <div class="text-sm text-gray-500">Prestador: {{ cupo.prestador }}</div>
                        </div>
                    </div>

                    <p v-else class="text-sm text-gray-500">Todavía no has tomado cupos.</p>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Citas disponibles</h3>

                    <div v-if="availableCitas.length" class="grid gap-4 lg:grid-cols-2">
                        <div v-for="cita in availableCitas" :key="cita.id" class="border rounded-lg p-4 space-y-3">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <div class="font-medium text-gray-900">{{ cita.descripcion }}</div>
                                    <div class="text-sm text-gray-500">{{ cita.fecha }}</div>
                                    <div class="text-sm text-gray-500">Prestador: {{ cita.prestador.name }}</div>
                                </div>

                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click.prevent="reserve(cita.id)">
                                    Tomar cupo
                                </PrimaryButton>
                            </div>

                            <div class="text-sm text-gray-600">Cupos disponibles: {{ cita.cupos_disponibles }} / {{ cita.cupos_totales }}</div>
                        </div>
                    </div>

                    <p v-else class="text-sm text-gray-500">No hay citas disponibles para tus prestadores suscritos.</p>

                    <p v-if="$page.props.flash?.status" class="mt-4 text-sm text-green-600">
                        {{ $page.props.flash.status }}
                    </p>

                    <p v-if="form.errors.cita" class="mt-4 text-sm text-red-600">
                        {{ form.errors.cita }}
                    </p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>