<?php

namespace App\Repositories\Contracts;

use App\Models\Cita;
use App\Models\Cupo;
use App\Models\User;
use Illuminate\Support\Collection;

interface CupoRepositoryInterface
{
	public function bookedSolicitantesForCita(Cita $cita): Collection;

	public function availableCitasForSolicitante(User $solicitante): Collection;

	public function bookedCuposForSolicitante(User $solicitante): Collection;

	public function reserveForSolicitante(User $solicitante, int $citaId): Cupo;
}