<?php

namespace App\Repositories;

use App\Tag;

class TagRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(Tag $tag)
    {
        $this->model = $tag;
    }

    /**
     * Get number of the records.
     *
     * @param  Request $request
     * @param  integer $number
     * @param  string  $sort
     * @param  string  $sortColumn
     * @return collection
     */
    public function pageWithRequest($request, $number = 10, $sort = 'desc', $sortColumn = 'created_at')
    {
        $keyword = $request->get('keyword');

        return $this->model
                    ->when($keyword, function ($query) use ($keyword) {
                        $query->where('tag', 'like', "%{$keyword}%")
                            ->orWhere('title', 'like', "%{$keyword}%");
                    })
                    ->orderBy($sortColumn, $sort)->paginate($number);
    }

    /**
     * Get record by the name.
     *
     * @param  string $name
     * @return collection
     */
    public function getByName($name)
    {
        return $this->model->where('tag', $name)->first();
    }
}
