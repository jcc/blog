<?php

namespace App\Traits;

use App\Tag;

trait HasTags
{
    /**
     * Get the tags for the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}