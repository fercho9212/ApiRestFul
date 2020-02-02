<?php

namespace App\Policies;

use App\User;
use App\Traits\AdminActions;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization,AdminActions;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $authenticatedUser
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $authenticatedUser, User $user)
    {
        return $authenticatedUser->id === $user->id;
    }


    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $authenticatedUser
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $authenticatedUser, User $user)
    {
        return $authenticatedUser->id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $authenticatedUser
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $authenticatedUser, User $user)
    {
        return $authenticatedUser->id === $user->id && $authenticatedUser->token()
               ->client->personal_access_client;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $authenticatedUser
     * @param  \App\User  $user
     * @return mixed
     */
    public function restore(User $authenticatedUser, User $user)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $authenticatedUser
     * @param  \App\User  $user
     * @return mixed
     */
    public function forceDelete(User $authenticatedUser, User $user)
    {
        //
    }
}
