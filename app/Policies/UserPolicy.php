<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->isAdministrator()
            ? Response::allow()
            : Response::deny('You are not authorized to view users.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): Response
    {
        return $user->isAdministrator()
            ? Response::allow()
            : Response::deny('You are not authorized to view this user.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->isAdministrator()
            ? Response::allow()
            : Response::deny('You are not authorized to create users.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): Response
    {
        if (
            $user->isAdministrator() &&
            !$model->isAdministrator() &&
            $user->id !== $model->id
        ) {
            return Response::allow();
        }

        return Response::deny('You are not authorized to update this user.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): Response
    {
        if (
            $user->isAdministrator() &&
            !$model->isAdministrator() &&
            $user->id !== $model->id
        ) {
            return Response::allow();
        }

        return Response::deny('You are not authorized to delete this user.');
    }
}
