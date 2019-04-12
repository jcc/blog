<?php

namespace App\Policies;

use App\User;
use App\Discussion;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiscussionPolicy extends Policy
{
    /**
     * Determine whether the user can update the discussion.
     *
     * @param  \App\User  $user
     * @param  \App\Discussion  $discussion
     * @return mixed
     */
    public function update(User $user, Discussion $discussion)
    {
        return $user->id === $discussion->user_id;
    }

    /**
     * Determine whether the user can delete the discussion.
     *
     * @param  \App\User  $user
     * @param  \App\Discussion  $discussion
     * @return mixed
     */
    public function delete(User $user, Discussion $discussion)
    {
        return false;
    }
}
