<script setup>
import Card from 'primevue/card';
</script>

<template>
    <div class="min-h-screen bg-slate-50 px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto grid min-h-[calc(100vh-3rem)] max-w-6xl items-center gap-6 lg:grid-cols-2">
            <div class="hidden rounded-3xl border border-slate-200 bg-white p-6 text-slate-900 shadow-sm lg:block">
                <div class="max-w-lg">
                    <slot name="logo" />
                    <p class="mt-6 text-[11px] uppercase tracking-[0.32em] text-slate-500">Sistema de citas</p>
                    <h1 class="mt-3 text-2xl font-semibold leading-tight text-slate-900">Agenda, suscripciones y cupos en una sola plataforma.</h1>
                    <p class="mt-3 text-sm text-slate-500">Diseño modular, sobrio y responsive con PrimeVue + Tailwind.</p>

                    <div class="mt-6 grid gap-3 sm:grid-cols-3">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3">
                            <p class="text-lg font-semibold">01</p>
                            <p class="text-xs text-slate-500">Registro</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3">
                            <p class="text-lg font-semibold">02</p>
                            <p class="text-xs text-slate-500">Roles</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3">
                            <p class="text-lg font-semibold">03</p>
                            <p class="text-xs text-slate-500">Cupos</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full">
                <div class="mb-4 lg:hidden">
                    <slot name="logo" />
                </div>

                <Card class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                    <template #content>
                        <div class="space-y-4 p-1.5 sm:p-3">
                            <slot />
                        </div>
                    </template>
                </Card>
            </div>
        </div>
    </div>
</template>
