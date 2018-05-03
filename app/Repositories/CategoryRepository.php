<?php

namespace App\Repositories;

use App\Category;

class CategoryRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(Category $category)
    {
        $this->model = $category;
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
                        $query->where('name', 'like', "%{$keyword}%");
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
        return $this->model->where('name', $name)->first();
    }
}
