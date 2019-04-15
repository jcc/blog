<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class VisitorFilter extends ModelFilter
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
        return $this->where('ip', 'like', "%{$keyword}%")
            ->orWhereHas('article', function ($query) use ($keyword) {
                $query->where('title', 'like', "%{$keyword}%");
            });
    }
}
