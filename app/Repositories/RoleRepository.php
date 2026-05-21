<?php

namespace App\Repositories;

use App\Models\Role;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Support\Collection;

class RoleRepository implements RoleRepositoryInterface
{
	private const DEFAULT_ROLES = [
		[
			'name' => 'Prestador',
			'description' => 'Crea citas y administra sus cupos',
		],
		[
			'name' => 'Solicitante',
			'description' => 'Se suscribe a prestadores y reserva cupos',
		],
	];

	public function all(): Collection
	{
		foreach (self::DEFAULT_ROLES as $roleData) {
			Role::firstOrCreate(['name' => $roleData['name']], ['description' => $roleData['description']]);
		}

		return Role::query()->orderBy('name')->get();
	}

	public function findByName(string $name)
	{
		return Role::query()->where('name', $name)->first();
	}

	public function findManyByIds(array $roleIds): Collection
	{
		return Role::query()->whereIn('id', $roleIds)->get();
	}
}