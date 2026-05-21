<?php

namespace App\Repositories\Contracts;

use App\Models\Cita;
use App\Models\User;
use Illuminate\Support\Collection;

interface CitaRepositoryInterface
{
	public function allForPrestador(User $prestador): Collection;

	public function findForPrestador(User $prestador, int $citaId): ?Cita;

	public function createForPrestador(User $prestador, array $data): Cita;
}