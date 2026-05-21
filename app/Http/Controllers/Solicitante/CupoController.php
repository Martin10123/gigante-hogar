<?php

namespace App\Http\Controllers\Solicitante;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCupoRequest;
use App\Repositories\Contracts\CupoRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use RuntimeException;

class CupoController extends Controller
{
    public function __construct(
        private readonly CupoRepositoryInterface $cupoRepository,
    ) {
    }

    public function index(Request $request): Response|RedirectResponse
    {
        $user = $request->user();

        if (! $user->hasRole('Solicitante')) {
            return redirect()->route('dashboard');
        }

        return Inertia::render('Solicitante/Citas', [
            'availableCitas' => $this->cupoRepository->availableCitasForSolicitante($user)->map(fn ($cita) => [
                'id' => $cita->id,
                'descripcion' => $cita->descripcion,
                'fecha' => optional($cita->fecha)->toDateString(),
                'cupos_totales' => $cita->cupos_totales,
                'cupos_disponibles' => $cita->cupos_disponibles,
                'prestador' => [
                    'id' => $cita->prestador?->id,
                    'name' => $cita->prestador?->name,
                    'email' => $cita->prestador?->email,
                ],
            ]),
            'myCupos' => $this->cupoRepository->bookedCuposForSolicitante($user)->map(fn ($cupo) => [
                'id' => $cupo->id,
                'cita_id' => $cupo->cita_id,
                'descripcion' => $cupo->cita?->descripcion,
                'fecha' => optional($cupo->cita?->fecha)->toDateString(),
                'prestador' => $cupo->cita?->prestador?->name,
            ]),
        ]);
    }

    public function store(StoreCupoRequest $request, int $cita): RedirectResponse
    {
        $user = $request->user();

        if (! $user->hasRole('Solicitante')) {
            return redirect()->route('dashboard');
        }

        try {
            $this->cupoRepository->reserveForSolicitante($user, $cita);
        } catch (RuntimeException $exception) {
            return back()->withErrors(['cita' => $exception->getMessage()]);
        }

        return back()->with('status', 'Cupo asignado exitosamente.');
    }
}