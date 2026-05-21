<script setup>
import Card from 'primevue/card';
</script>

<template>
    <div class="min-h-screen bg-slate-50 px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto grid min-h-[calc(100vh-4rem)] max-w-7xl items-center gap-8 lg:grid-cols-2">
            <div class="hidden rounded-[2rem] border border-slate-200 bg-gradient-to-br from-cyan-50 via-blue-50 to-indigo-50 p-8 text-slate-900 shadow-sm lg:block">
                <div class="max-w-xl">
                    <slot name="logo" />
                    <p class="mt-8 text-sm uppercase tracking-[0.35em] text-cyan-700/70">Sistema de citas</p>
                    <h1 class="mt-4 text-4xl font-bold leading-tight">Agenda, suscripciones y cupos en una sola plataforma.</h1>
                    <p class="mt-4 text-slate-600">Diseño moderno, modular y responsive con PrimeVue + Tailwind.</p>

                    <div class="mt-8 grid gap-4 sm:grid-cols-3">
                        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                            <p class="text-2xl font-bold">01</p>
                            <p class="text-sm text-slate-500">Registro</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                            <p class="text-2xl font-bold">02</p>
                            <p class="text-sm text-slate-500">Roles</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                            <p class="text-2xl font-bold">03</p>
                            <p class="text-sm text-slate-500">Cupos</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full">
                <div class="mb-6 lg:hidden">
                    <slot name="logo" />
                </div>

                <Card class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                    <template #content>
                        <div class="space-y-6 p-2 sm:p-4">
                            <slot />
                        </div>
                    </template>
                </Card>
            </div>
        </div>
    </div>
</template>
