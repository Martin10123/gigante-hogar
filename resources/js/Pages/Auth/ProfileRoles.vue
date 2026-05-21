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
            <h2 class="text-base font-semibold tracking-tight text-slate-900">
                Asignar perfil
            </h2>
        </template>

        <div class="py-6 sm:py-8">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                    <p class="mb-4 text-xs uppercase tracking-[0.18em] text-slate-500">
                        Selecciona uno o ambos perfiles para habilitar las funciones del sistema.
                    </p>

                    <form @submit.prevent="submit" class="space-y-3">
                        <div v-for="role in roles" :key="role.id" class="rounded-xl border border-slate-200 p-3.5">
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input
                                    type="checkbox"
                                    class="mt-0.5 h-4 w-4 rounded border-slate-300 text-slate-900 focus:ring-slate-400"
                                    :checked="form.roles.includes(role.id)"
                                    @change="toggleRole(role.id)"
                                />

                                <div>
                                    <div class="text-sm font-medium text-slate-900">{{ role.name }}</div>
                                    <div class="text-xs text-slate-500">{{ role.description }}</div>
                                </div>
                            </label>
                        </div>

                        <InputError class="mt-1" :message="form.errors.roles" />

                        <div class="flex justify-end">
                            <PrimaryButton class="!text-xs" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Guardar perfil
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>