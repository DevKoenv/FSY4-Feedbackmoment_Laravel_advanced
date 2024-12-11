<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EventPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Event $event): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->isAdministrator()
            ? Response::allow()
            : Response::deny('You do not have permission to create events.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Event $event): Response
    {
        return $user->isAdministrator()
            ? Response::allow()
            : Response::deny('You do not have permission to update this event.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Event $event): Response
    {
        return $user->isAdministrator()
            ? Response::allow()
            : Response::deny('You do not have permission to delete this event.');
    }
}
