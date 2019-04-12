<?php

namespace App\Traits;

use App\Comment;

Trait HasComments
{
    /**
     * Get the comments for the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\morphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}