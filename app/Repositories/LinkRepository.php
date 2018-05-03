<?php

namespace App\Repositories;

use App\Link;
use App\Scopes\StatusScope;

class LinkRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(Link $link)
    {
        $this->model = $link;
    }

    /**
     * Get number of the records
     *
     * @param  int $number
     * @param  string $sort
     * @param  string $sortColumn
     * @return Paginate
     */
    public function page($number = 10, $sort = 'desc', $sortColumn = 'created_at')
    {
        $this->model = $this->checkAuthScope();

        return $this->model->orderBy($sortColumn, $sort)->paginate($number);
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
        $this->model = $this->checkAuthScope();

        $keyword = $request->get('keyword');

        return $this->model
                    ->when($keyword, function ($query) use ($keyword) {
                        $query->where('name', 'like', "%{$keyword}%");
                    })
                    ->orderBy($sortColumn, $sort)->paginate($number);
    }

    /**
     * Get the article record without draft scope.
     *
     * @param  int $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->model->withoutGlobalScope(StatusScope::class)->findOrFail($id);
    }

    /**
     * Update the article record without draft scope.
     *
     * @param  int $id
     * @param  array $input
     * @return boolean
     */
    public function update($id, $input)
    {
        $this->model = $this->model->withoutGlobalScope(StatusScope::class)->findOrFail($id);

        return $this->save($this->model, $input);
    }

    /**
     * Check the auth and the model without global scope when user is the admin.
     *
     * @return Model
     */
    public function checkAuthScope()
    {
        if (auth()->check() && auth()->user()->is_admin) {
            $this->model = $this->model->withoutGlobalScope(StatusScope::class);
        }

        return $this->model;
    }

    /**
     * Delete the draft article.
     *
     * @param int $id
     * @return boolean
     */
    public function destroy($id)
    {
        return $this->getById($id)->delete();
    }
}
