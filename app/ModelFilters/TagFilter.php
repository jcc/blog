<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class TagFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function keyword($keyword)
    {
        return $this->where('tag', 'like', "%{$keyword}%")->orWhere('title', 'like', "%{$keyword}%");
    }
}
