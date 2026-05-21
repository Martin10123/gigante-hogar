<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    citas: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    descripcion: '',
    fecha: '',
    cupos_totales: 1,
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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mis citas
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Crear cita</h3>

                    <div class="grid gap-4 md:grid-cols-3">
                        <div>
                            <InputLabel value="Descripción" />
                            <TextInput v-model="form.descripcion" type="text" class="mt-1 block w-full" />
                            <InputError class="mt-2" :message="form.errors.descripcion" />
                        </div>

                        <div>
                            <InputLabel value="Fecha" />
                            <TextInput v-model="form.fecha" type="date" class="mt-1 block w-full" />
                            <InputError class="mt-2" :message="form.errors.fecha" />
                        </div>

                        <div>
                            <InputLabel value="Cupos totales" />
                            <TextInput v-model="form.cupos_totales" type="number" min="1" class="mt-1 block w-full" />
                            <InputError class="mt-2" :message="form.errors.cupos_totales" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click.prevent="submit">
                            Crear cita
                        </PrimaryButton>
                    </div>

                    <p v-if="$page.props.flash?.status" class="mt-4 text-sm text-green-600">
                        {{ $page.props.flash.status }}
                    </p>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Citas registradas</h3>

                    <div v-if="citas.length" class="grid gap-4 lg:grid-cols-2">
                        <div v-for="cita in citas" :key="cita.id" class="border rounded-lg p-4 space-y-2">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <div class="font-medium text-gray-900">{{ cita.descripcion }}</div>
                                    <div class="text-sm text-gray-500">{{ cita.fecha }}</div>
                                </div>

                                <Link :href="route('prestador.citas.show', cita.id)" class="text-sm text-indigo-600 hover:text-indigo-800">
                                    Ver inscritos
                                </Link>
                            </div>

                            <div class="text-sm text-gray-600">
                                Cupos: {{ cita.cupos_disponibles }} / {{ cita.cupos_totales }}
                            </div>
                            <div class="text-sm text-gray-600">
                                Inscritos: {{ cita.cupos_count }}
                            </div>
                        </div>
                    </div>

                    <p v-else class="text-sm text-gray-500">Aún no has creado citas.</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>