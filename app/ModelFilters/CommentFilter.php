<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class CommentFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = ['user' => 'keyword'];

    public function commentableType($commentableType)
    {
        return $this->where('commentable_type', $commentableType);
    }
}
