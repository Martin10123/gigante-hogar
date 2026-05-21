<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
	public function syncRoles(User $user, array $roleIds): User;

	public function findById(int $id): ?User;

	public function allPrestadores();
}