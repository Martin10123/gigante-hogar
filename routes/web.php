<?php

use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Prestador\CitaController;
use App\Http\Controllers\Solicitante\CupoController;
use App\Http\Controllers\Solicitante\SuscripcionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('register');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/perfil', [ProfileController::class, 'create'])->name('profile.roles.create');
    Route::post('/perfil', [ProfileController::class, 'store'])->name('profile.roles.store');

    Route::get('/dashboard', function (Request $request) {
        if (! $request->user()->roles()->exists()) {
            return redirect()->route('profile.roles.create');
        }

        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/solicitante/prestadores', [SuscripcionController::class, 'index'])->name('suscripciones.index');
    Route::post('/solicitante/prestadores', [SuscripcionController::class, 'store'])->name('suscripciones.store');

    Route::get('/solicitante/citas', [CupoController::class, 'index'])->name('solicitante.citas.index');
    Route::post('/solicitante/citas/{cita}', [CupoController::class, 'store'])->name('solicitante.cupos.store');

    Route::get('/prestador/citas', [CitaController::class, 'index'])->name('prestador.citas.index');
    Route::post('/prestador/citas', [CitaController::class, 'store'])->name('prestador.citas.store');
    Route::get('/prestador/citas/{cita}', [CitaController::class, 'show'])->name('prestador.citas.show');
});
