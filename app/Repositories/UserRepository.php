<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface
{
	public function syncRoles(User $user, array $roleIds): User
	{
		$user->assignRoles($roleIds);

		return $user->load('roles');
	}

	public function findById(int $id): ?User
	{
		return User::query()->with('roles')->find($id);
	}

	public function allPrestadores(): Collection
	{
		return User::query()
			->whereHas('roles', fn ($query) => $query->where('name', 'Prestador'))
			->orderBy('name')
			->get();
	}
}