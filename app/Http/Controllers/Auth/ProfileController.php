<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProfileRolesRequest;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function __construct(
        private readonly RoleRepositoryInterface $roleRepository,
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    public function create(): Response
    {
        return Inertia::render('Auth/ProfileRoles', [
            'roles' => $this->roleRepository->all()->map(fn ($role) => [
                'id' => $role->id,
                'name' => $role->name,
                'description' => $role->description,
            ]),
        ]);
    }

    public function store(StoreProfileRolesRequest $request): RedirectResponse
    {
        $this->userRepository->syncRoles($request->user(), $request->validated('roles'));

        return redirect()->route('dashboard')->with('status', 'Perfil asignado correctamente.');
    }
}