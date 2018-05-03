<?php

namespace App\Repositories;

use Auth;
use App\User;
use App\Scopes\StatusScope;

class UserRepository
{
    use BaseRepository;

    /**
     * User Model
     *
     * @var User
     */
    protected $model;

    /**
     * Constructor
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Get the list of all the user without myself.
     *
     * @return mixed
     */
    public function getList()
    {
        return $this->model
            ->orderBy('id', 'desc')
            ->get();
    }

    /**
     * Get the user by name.
     *
     * @param  string $name
     * @return mixed
     */
    public function getByName($name)
    {
        return $this->model
                    ->where('name', $name)
                    ->first();
    }

    /**
     * Get number of the records
     *
     * @param  Request $request
     * @param  int $number
     * @param  string $sort
     * @param  string $sortColumn
     * @return Paginate
     */
    public function pageWithRequest($request, $number = 10, $sort = 'desc', $sortColumn = 'created_at')
    {
        $keyword = $request->get('keyword');

        return $this->model->withoutGlobalScope(StatusScope::class)
                    ->when($keyword, function ($query) use ($keyword) {
                        $query->where('name', 'like', "%{$keyword}%");
                    })
                    ->orderBy($sortColumn, $sort)
                    ->paginate($number);
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
        return $this->model->withoutGlobalScope(StatusScope::class)->orderBy($sortColumn, $sort)->paginate($number);
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
     * Get user by the user github id.
     *
     * @param  int $githubId
     * @return mixed
     */
    public function getByGithubId($githubId)
    {
        return $this->model->where('github_id', $githubId)->first();
    }

    /**
     * Change the user password.
     *
     * @param  App\User $user
     * @param  string $password
     * @return boolean
     */
    public function changePassword($user, $password)
    {
        return $user->update(['password' => bcrypt($password)]);
    }

    /**
     * Save the user avatar path.
     *
     * @param  int $id
     * @param  string $photo
     * @return boolean
     */
    public function saveAvatar($id, $photo)
    {
        $user = $this->getById($id);

        $user->avatar = $photo;

        return $user->save();
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
