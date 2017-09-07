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
     * Get record by the name.
     * 
     * @param  string $name
     * @return Category
     */
    public function getByName($name)
    {
        return $this->model->where('slug', $name)->first();
    }
}
