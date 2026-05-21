<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';

defineProps({
    roles: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    roles: [],
});

const toggleRole = (roleId) => {
    if (form.roles.includes(roleId)) {
        form.roles = form.roles.filter((selectedRole) => selectedRole !== roleId);
        return;
    }

    if (form.roles.length >= 2) {
        return;
    }

    form.roles.push(roleId);
};

const submit = () => {
    form.post(route('profile.roles.store'));
};
</script>

<template>
    <Head title="Asignar perfil" />

    <AppLayout title="Asignar perfil">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Asignar perfil
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                    <p class="text-sm text-gray-600 mb-6">
                        Selecciona uno o ambos perfiles para habilitar las funciones del sistema.
                    </p>

                    <form @submit.prevent="submit" class="space-y-4">
                        <div v-for="role in roles" :key="role.id" class="border rounded-lg p-4">
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input
                                    type="checkbox"
                                    class="mt-1"
                                    :checked="form.roles.includes(role.id)"
                                    @change="toggleRole(role.id)"
                                />

                                <div>
                                    <div class="font-medium text-gray-900">{{ role.name }}</div>
                                    <div class="text-sm text-gray-500">{{ role.description }}</div>
                                </div>
                            </label>
                        </div>

                        <InputError class="mt-2" :message="form.errors.roles" />

                        <div class="flex justify-end">
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Guardar perfil
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>