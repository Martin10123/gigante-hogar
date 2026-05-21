<?php

namespace App\Repositories;

use App\Models\Suscripcion;
use App\Models\User;
use App\Repositories\Contracts\SuscripcionRepositoryInterface;
use Illuminate\Support\Collection;

class SuscripcionRepository implements SuscripcionRepositoryInterface
{
	public function availablePrestadoresForSolicitante(User $solicitante): Collection
	{
		$subscribedIds = Suscripcion::query()
			->where('solicitante_id', $solicitante->id)
			->pluck('prestador_id');

		return User::query()
			->whereHas('roles', fn ($query) => $query->where('name', 'Prestador'))
			->whereNotIn('id', $subscribedIds)
			->orderBy('name')
			->get();
	}

	public function subscribedPrestadoresForSolicitante(User $solicitante): Collection
	{
		return User::query()
			->whereHas('roles', fn ($query) => $query->where('name', 'Prestador'))
			->whereIn('id', Suscripcion::query()
				->where('solicitante_id', $solicitante->id)
				->pluck('prestador_id'))
			->orderBy('name')
			->get();
	}

	public function isSubscribed(int $solicitanteId, int $prestadorId): bool
	{
		return Suscripcion::query()
			->where('solicitante_id', $solicitanteId)
			->where('prestador_id', $prestadorId)
			->exists();
	}

	public function subscribe(User $solicitante, User $prestador): Suscripcion
	{
		return Suscripcion::query()->create([
			'solicitante_id' => $solicitante->id,
			'prestador_id' => $prestador->id,
		]);
	}
}