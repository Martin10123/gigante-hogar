<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface RoleRepositoryInterface
{
	public function all(): Collection;

	public function findByName(string $name);

	public function findManyByIds(array $roleIds): Collection;
}