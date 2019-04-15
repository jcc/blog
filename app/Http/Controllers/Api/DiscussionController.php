<?php

namespace App\Http\Controllers\Api;

use App\Discussion;
use Illuminate\Http\Request;
use App\Http\Requests\DiscussionRequest;

class DiscussionController extends ApiController
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
        $discussions = Discussion::checkAuth()->filter($request->all())->orderBy('created_at', 'desc')->paginate(10);

        return $this->response->collection($discussions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\DiscussionRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DiscussionRequest $request)
    {
        $data = array_merge($request->all(), [
            'user_id' => \Auth::id(),
            'last_user_id' => \Auth::id(),
        ]);

        $discussion = Discussion::create($data);

        if (is_array($data['tags'])) {
            $discussion->tags()->sync($data['tags']);
        } else {
            $discussion->tags()->sync(json_decode($data['tags']));
        }

        return $this->response->withNoContent();
    }

    /**
     * Update Discussion Status By Discussion ID.
     *
     * @param $id
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function status($id, Request $request)
    {
        Discussion::checkAuth()->findOrFail($id)->update($request->all());

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
        $discussion = Discussion::checkAuth()->findOrFail($id);

        return $this->response->item($discussion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\DiscussionRequest $request
     * @param int                                  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(DiscussionRequest $request, $id)
    {
        $data = array_merge($request->all(), [
            'last_user_id' => \Auth::id(),
        ]);

        $discussion = Discussion::checkAuth()->findOrFail($id);

        if (is_array($data['tags'])) {
            $discussion->tags()->sync($data['tags']);
        } else {
            $discussion->tags()->sync(json_decode($data['tags']));
        }

        $discussion->update($data);

        return $this->response->withNoContent();
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
        Discussion::checkAuth()->findOrFail($id)->delete();

        return $this->response->withNoContent();
    }
}
