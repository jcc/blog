<?php

namespace App\Policies;

use App\User;
use App\Comment;

class CommentPolicy extends Policy
{
    /**
     * Determine whether the user can delete the comment.
     *
     * @param  \App\User  $user
     * @param  \App\Comment  $comment
     * @return mixed
     */
    public function delete(User $user, Comment $comment)
    {
        return $comment->user_id === $user->id;
    }
}
