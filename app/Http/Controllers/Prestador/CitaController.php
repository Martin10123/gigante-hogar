<?php

namespace App\Http\Controllers\Prestador;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCitaRequest;
use App\Repositories\Contracts\CitaRepositoryInterface;
use App\Repositories\Contracts\CupoRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CitaController extends Controller
{
    public function __construct(
        private readonly CitaRepositoryInterface $citaRepository,
        private readonly CupoRepositoryInterface $cupoRepository,
    ) {
    }

    public function index(Request $request): Response|RedirectResponse
    {
        $user = $request->user();

        if (! $user->hasRole('Prestador')) {
            return redirect()->route('dashboard');
        }

        return Inertia::render('Prestador/Citas', [
            'citas' => $this->citaRepository->allForPrestador($user)->map(fn ($cita) => [
                'id' => $cita->id,
                'descripcion' => $cita->descripcion,
                'fecha' => optional($cita->fecha)->toDateString(),
                'cupos_totales' => $cita->cupos_totales,
                'cupos_disponibles' => $cita->cupos_disponibles,
                'cupos_count' => $cita->cupos_count,
            ]),
        ]);
    }

    public function store(StoreCitaRequest $request): RedirectResponse
    {
        $user = $request->user();

        if (! $user->hasRole('Prestador')) {
            return redirect()->route('dashboard');
        }

        $this->citaRepository->createForPrestador($user, $request->validated());

        return back()->with('status', 'Cita creada exitosamente.');
    }

    public function show(Request $request, int $cita): Response|RedirectResponse
    {
        $user = $request->user();

        if (! $user->hasRole('Prestador')) {
            return redirect()->route('dashboard');
        }

        $citaModel = $this->citaRepository->findForPrestador($user, $cita);

        if (! $citaModel) {
            abort(404);
        }

        return Inertia::render('Prestador/CitaShow', [
            'cita' => [
                'id' => $citaModel->id,
                'descripcion' => $citaModel->descripcion,
                'fecha' => optional($citaModel->fecha)->toDateString(),
                'cupos_totales' => $citaModel->cupos_totales,
                'cupos_disponibles' => $citaModel->cupos_disponibles,
                'solicitantes' => $this->cupoRepository->bookedSolicitantesForCita($citaModel)->map(fn ($solicitante) => [
                    'id' => $solicitante->id,
                    'name' => $solicitante->name,
                    'email' => $solicitante->email,
                ]),
            ],
        ]);
    }
}