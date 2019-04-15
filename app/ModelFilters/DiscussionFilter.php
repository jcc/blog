<?php namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class DiscussionFilter extends ModelFilter
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
        return $this->where('title', 'like', "%{$keyword}%")
            ->orWhereHas('user', function ($query) use ($keyword) {
                $query->where('name', 'like', "%{$keyword}%");
            });
    }
}
