<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-500">Resumen</p>
                    <h2 class="text-2xl font-bold text-slate-900">Dashboard</h2>
                </div>
                <p class="text-sm text-slate-600">Accesos rápidos al flujo principal.</p>
            </div>
        </template>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="rounded-3xl border border-cyan-100 bg-gradient-to-br from-cyan-50 to-white p-6 shadow-sm">
                <p class="text-sm text-cyan-700">Prestador</p>
                <h3 class="mt-2 text-xl font-semibold text-slate-900">Crear y gestionar citas</h3>
                <p class="mt-2 text-sm text-slate-600">Ve tus citas y revisa inscritos desde el panel.</p>
            </div>

            <div class="rounded-3xl border border-violet-100 bg-gradient-to-br from-violet-50 to-white p-6 shadow-sm">
                <p class="text-sm text-violet-700">Solicitante</p>
                <h3 class="mt-2 text-xl font-semibold text-slate-900">Suscribirte y reservar</h3>
                <p class="mt-2 text-sm text-slate-600">Accede a prestadores y toma cupos disponibles.</p>
            </div>

            <div class="rounded-3xl border border-emerald-100 bg-gradient-to-br from-emerald-50 to-white p-6 shadow-sm">
                <p class="text-sm text-emerald-700">Estado</p>
                <h3 class="mt-2 text-xl font-semibold text-slate-900">Diseño renovado</h3>
                <p class="mt-2 text-sm text-slate-600">Navbar, sidebar y auth con estilo moderno.</p>
            </div>
        </div>

        <div class="mt-6 grid gap-6 lg:grid-cols-2">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Acceso rápido</h3>
                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    <a class="rounded-2xl bg-slate-50 px-4 py-3 text-slate-700 hover:bg-slate-100 hover:text-slate-900" :href="route('prestador.citas.index')">Mis citas</a>
                    <a class="rounded-2xl bg-slate-50 px-4 py-3 text-slate-700 hover:bg-slate-100 hover:text-slate-900" :href="route('solicitante.citas.index')">Citas disponibles</a>
                    <a class="rounded-2xl bg-slate-50 px-4 py-3 text-slate-700 hover:bg-slate-100 hover:text-slate-900" :href="route('suscripciones.index')">Prestadores</a>
                    <a class="rounded-2xl bg-slate-50 px-4 py-3 text-slate-700 hover:bg-slate-100 hover:text-slate-900" :href="route('profile.roles.create')">Perfil</a>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-gradient-to-br from-slate-50 to-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Inicio sin welcome</h3>
                <p class="mt-2 text-sm text-slate-600">La ruta raíz ahora manda al registro para invitados.</p>
            </div>
        </div>
    </AppLayout>
</template>
