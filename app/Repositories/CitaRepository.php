<?php

namespace App\Repositories;

use App\Models\Cita;
use App\Models\User;
use App\Repositories\Contracts\CitaRepositoryInterface;
use Illuminate\Support\Collection;

class CitaRepository implements CitaRepositoryInterface
{
	public function allForPrestador(User $prestador): Collection
	{
		return Cita::query()
			->withCount('cupos')
			->where('prestador_id', $prestador->id)
			->orderByDesc('fecha')
			->orderByDesc('id')
			->get();
	}

	public function findForPrestador(User $prestador, int $citaId): ?Cita
	{
		return Cita::query()
			->with(['cupos.solicitante'])
			->where('prestador_id', $prestador->id)
			->find($citaId);
	}

	public function createForPrestador(User $prestador, array $data): Cita
	{
		return Cita::query()->create([
			'prestador_id' => $prestador->id,
			'descripcion' => $data['descripcion'],
			'fecha' => $data['fecha'],
			'cupos_totales' => $data['cupos_totales'],
			'cupos_disponibles' => $data['cupos_totales'],
		]);
	}
}