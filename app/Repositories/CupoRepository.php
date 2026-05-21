<?php

namespace App\Repositories;

use App\Models\Cita;
use App\Models\Cupo;
use App\Repositories\Contracts\CupoRepositoryInterface;
use App\Models\User;
use App\Repositories\Contracts\SuscripcionRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use RuntimeException;

class CupoRepository implements CupoRepositoryInterface
{
	public function __construct(
		private readonly SuscripcionRepositoryInterface $suscripcionRepository,
	) {
	}

	public function bookedSolicitantesForCita(Cita $cita): Collection
	{
		return $cita->cupos()->with('solicitante')->get()->map(fn ($cupo) => $cupo->solicitante)->filter()->values();
	}

	public function availableCitasForSolicitante(User $solicitante): Collection
	{
		$prestadorIds = $this->suscripcionRepository->subscribedPrestadoresForSolicitante($solicitante)->pluck('id');

		if ($prestadorIds->isEmpty()) {
			return collect();
		}

		return Cita::query()
			->with('prestador')
			->withCount('cupos')
			->whereIn('prestador_id', $prestadorIds)
			->whereDate('fecha', '>=', today())
			->where('cupos_disponibles', '>', 0)
			->orderBy('fecha')
			->orderBy('id')
			->get();
	}

	public function bookedCuposForSolicitante(User $solicitante): Collection
	{
		return Cupo::query()
			->with(['cita.prestador'])
			->where('solicitante_id', $solicitante->id)
			->orderByDesc('id')
			->get();
	}

	public function reserveForSolicitante(User $solicitante, int $citaId): Cupo
	{
		return DB::transaction(function () use ($solicitante, $citaId) {
			$cita = Cita::query()
				->with('prestador')
				->lockForUpdate()
				->find($citaId);

			if (! $cita) {
				throw new RuntimeException('Cita no encontrada.');
			}

			if (! $this->suscripcionRepository->isSubscribed($solicitante->id, $cita->prestador_id)) {
				throw new RuntimeException('No estás suscrito a este prestador.');
			}

			$alreadyBooked = Cupo::query()
				->where('cita_id', $cita->id)
				->where('solicitante_id', $solicitante->id)
				->exists();

			if ($alreadyBooked) {
				throw new RuntimeException('Ya tienes un cupo asignado en esta cita.');
			}

			if ($cita->cupos_disponibles <= 0) {
				throw new RuntimeException('No hay cupos disponibles.');
			}

			$cupo = Cupo::query()->create([
				'cita_id' => $cita->id,
				'solicitante_id' => $solicitante->id,
			]);

			$cita->decrement('cupos_disponibles');

			return $cupo;
		});
	}
}