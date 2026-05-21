<?php

namespace App\Repositories\Contracts;

use App\Models\Suscripcion;
use App\Models\User;
use Illuminate\Support\Collection;

interface SuscripcionRepositoryInterface
{
	public function availablePrestadoresForSolicitante(User $solicitante): Collection;

	public function subscribedPrestadoresForSolicitante(User $solicitante): Collection;

	public function isSubscribed(int $solicitanteId, int $prestadorId): bool;

	public function subscribe(User $solicitante, User $prestador): Suscripcion;
}