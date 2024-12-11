<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->isAdministrator()
            ? Response::allow()
            : Response::deny('You are not authorized to view roles.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Role $role): Response
    {
        return $user->isAdministrator()
            ? Response::allow()
            : Response::deny('You are not authorized to view this role.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->isAdministrator()
            ? Response::allow()
            : Response::deny('You are not authorized to create roles.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Role $role): Response
    {
        return $user->isAdministrator()
            ? Response::allow()
            : Response::deny('You are not authorized to update this role.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Role $role): Response
    {
        if (
            $user->isAdministrator() &&
            $role->users->count() === 0
        ) {
            return Response::allow();
        }
    }
}
