<?php

namespace App\Http\Controllers\Api;

use App\Scopes\StatusScope;
use App\User;
use Illuminate\Support\Str;
use Image;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $users = User::withoutGlobalScope(StatusScope::class)
            ->filter($request->all())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return $this->response->collection($users);
    }

    /**
     * Update User Status By User ID.
     *
     * @param $id
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function status(Request $request, $id)
    {
        $input = $request->all();
        $user = User::withoutGlobalScope(StatusScope::class)->findOrFail($id);
        if (auth()->user()->id == $id || $user->is_admin) {
            return $this->response->withUnauthorized('You can\'t change status for yourself and other Administrators!');
        }

        $user->update($input);

        return $this->response->withNoContent();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\UserRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        $data = array_merge($request->all(), [
            'password' => bcrypt($request->get('password')),
            'confirm_code' => Str::random(64),
        ]);

        \DB::transaction(function () use ($request, $data) {
            $user = User::create($data);

            $user->syncRoles($request->get('roles'));
        });

        return $this->response->withNoContent();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function edit($id)
    {
        $user = User::withoutGlobalScopes()->findOrFail($id);

        return $this->response->item($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        \DB::transaction(function () use ($request, $user) {
            $user->update($request->all());

            $user->syncRoles($request->get('roles'));
        });

        return $this->response->withNoContent();
    }

    /**
     * Crop Avatar.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cropAvatar(Request $request)
    {
        $currentImage = $request->get('image');
        $data = $request->get('data');

        $image = Image::make($currentImage['relative_url']);

        $image->crop((int) $data['width'], (int) $data['height'], (int) $data['x'], (int) $data['y']);

        $image->save($currentImage['relative_url']);

        auth()->user()->update(['avatar' => $currentImage['url']]);

        return $this->response->json($currentImage);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (auth()->user()->id == $id || $user->is_admin) {
            return $this->response->withUnauthorized('You can\'t delete for yourself and other Administrators!');
        }

        $user->destroy($id);

        return $this->response->withNoContent();
    }
}
