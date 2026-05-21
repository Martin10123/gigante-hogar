<script setup>
import { Head, useForm } from '@inertiajs/vue3';
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

const form = useForm({
    prestador_id: '',
});

const subscribe = (prestadorId) => {
    form.prestador_id = prestadorId;
    form.post(route('suscripciones.store'));
};
</script>

<template>
    <Head title="Prestadores" />

    <AppLayout title="Prestadores">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Prestadores
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Prestadores suscritos</h3>

                    <div v-if="subscribedPrestadores.length" class="grid gap-3 md:grid-cols-2">
                        <div v-for="prestador in subscribedPrestadores" :key="prestador.id" class="border rounded-lg p-4">
                            <div class="font-medium text-gray-900">{{ prestador.name }}</div>
                            <div class="text-sm text-gray-500">{{ prestador.email }}</div>
                        </div>
                    </div>

                    <p v-else class="text-sm text-gray-500">Todavía no tienes prestadores suscritos.</p>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Prestadores disponibles</h3>

                    <div v-if="availablePrestadores.length" class="grid gap-3 md:grid-cols-2">
                        <div v-for="prestador in availablePrestadores" :key="prestador.id" class="border rounded-lg p-4 flex items-center justify-between gap-4">
                            <div>
                                <div class="font-medium text-gray-900">{{ prestador.name }}</div>
                                <div class="text-sm text-gray-500">{{ prestador.email }}</div>
                            </div>

                            <PrimaryButton
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                                @click.prevent="subscribe(prestador.id)"
                            >
                                Suscribirme
                            </PrimaryButton>
                        </div>
                    </div>

                    <p v-else class="text-sm text-gray-500">No hay prestadores disponibles para suscribirse.</p>

                    <InputError class="mt-4" :message="form.errors.prestador_id" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>