<?php

namespace App\Policies;

use App\Models\Attendee;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AttendeePolicy
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
    public function view(User $user, Attendee $attendee): Response
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
            : Response::deny('You do not have permission to create attendees.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Attendee $attendee): Response
    {
        return $user->isAdministrator()
            ? Response::allow()
            : Response::deny('You do not have permission to update this attendee.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Attendee $attendee): Response
    {
        return $user->isAdministrator()
            ? Response::allow()
            : Response::deny('You do not have permission to delete this attendee.');
    }
}
