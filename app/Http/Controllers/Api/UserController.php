<?php

namespace App\Http\Controllers\Api;

use Image;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use App\Transformers\UserTransformer;

class UserController extends ApiController
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        parent::__construct();

        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->respondWithPaginator($this->user->page(), new UserTransformer);
    }

    /**
     * Update User Status By User ID
     *
     * @param $id
     * @param Request $request
     * @return \App\User
     */
    public function status($id, Request $request)
    {
        $input = $request->all();

        if (auth()->user()->id == $id || $this->user->getById($id)->is_admin) {
            return $this->errorUnauthorized('You can\'t change status for yourself and other Administrators!');
        }

        $this->user->update($id, $input);

        return $this->noContent();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $data = array_merge($request->all(), [
            'password' => bcrypt($request->get('password')),
            'confirm_code' => str_random(64)
        ]);

        $this->user->store($data);

        return $this->noContent();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->respondWithItem($this->user->getById($id), new UserTransformer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->user->update($id, $request->all());

        return $this->noContent();
    }

    /**
     * Crop Avatar
     * 
     * @param  Request $request
     * @return array
     */
    public function cropAvatar(Request $request)
    {
        $currentImage = $request->get('image');
        $data = $request->get('data');

        $image = Image::make($currentImage['relative_url']);

        $image->crop((int) $data['width'], (int) $data['height'], (int) $data['x'], (int) $data['y']);

        $image->save($currentImage['relative_url']);

        $this->user->saveAvatar(auth()->user()->id, $currentImage['url']);

        return $this->respondWithArray($currentImage);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (auth()->user()->id == $id || $this->user->getById($id)->is_admin) {
            return $this->errorUnauthorized('You can\'t delete for yourself and other Administrators!');
        }

        $this->user->destroy($id);

        return $this->noContent();
    }
}
