<?php

namespace App\Policies;

use App\User;

class UserPolicy extends Policy
{
    /**
     * Determine whether the current user can update the user.
     *
     * @param  \App\User  $currentUser
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }

    /**
     * Determine whether the current user can delete the user.
     *
     * @param  \App\User  $currentUser
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $currentUser, User $user)
    {
        return false;
    }
}
