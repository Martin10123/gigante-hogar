<?php

namespace App\Http\Controllers\Solicitante;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSuscripcionRequest;
use App\Repositories\Contracts\SuscripcionRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SuscripcionController extends Controller
{
    public function __construct(
        private readonly SuscripcionRepositoryInterface $suscripcionRepository,
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    public function index(Request $request): Response|RedirectResponse
    {
        $user = $request->user();

        if (! $user->hasRole('Solicitante')) {
            return redirect()->route('dashboard');
        }

        return Inertia::render('Solicitante/Prestadores', [
            'availablePrestadores' => $this->suscripcionRepository->availablePrestadoresForSolicitante($user)->map(fn ($prestador) => [
                'id' => $prestador->id,
                'name' => $prestador->name,
                'email' => $prestador->email,
            ]),
            'subscribedPrestadores' => $this->suscripcionRepository->subscribedPrestadoresForSolicitante($user)->map(fn ($prestador) => [
                'id' => $prestador->id,
                'name' => $prestador->name,
                'email' => $prestador->email,
            ]),
        ]);
    }

    public function store(StoreSuscripcionRequest $request): RedirectResponse
    {
        $user = $request->user();

        if (! $user->hasRole('Solicitante')) {
            return redirect()->route('dashboard');
        }

        $prestador = $this->userRepository->findById((int) $request->validated('prestador_id'));

        if (! $prestador || ! $prestador->hasRole('Prestador')) {
            return back()->withErrors(['prestador_id' => 'El usuario seleccionado no es un prestador válido.']);
        }

        if ($this->suscripcionRepository->isSubscribed($user->id, $prestador->id)) {
            return back()->withErrors(['prestador_id' => 'Ya estás suscrito a este prestador.']);
        }

        $this->suscripcionRepository->subscribe($user, $prestador);

        return back()->with('status', 'Suscripción realizada exitosamente.');
    }
}