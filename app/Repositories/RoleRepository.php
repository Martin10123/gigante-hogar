<?php

namespace App\Repositories;

use App\Models\Role;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Support\Collection;

class RoleRepository implements RoleRepositoryInterface
{
	public function all(): Collection
	{
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