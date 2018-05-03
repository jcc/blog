<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\DiscussionRequest;
use App\Repositories\DiscussionRepository;

class DiscussionController extends ApiController
{
    protected $discussion;

    public function __construct(DiscussionRepository $discussion)
    {
        parent::__construct();

        $this->discussion = $discussion;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return $this->response->collection($this->discussion->pageWithRequest($request));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\DiscussionRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DiscussionRequest $request)
    {
        $data = array_merge($request->all(), [
            'user_id'      => \Auth::id(),
            'last_user_id' => \Auth::id()
        ]);

        $data['content'] = $data['content'];

        $this->discussion->store($data);

        return $this->response->withNoContent();
    }

    /**
     * Update Discussion Status By Discussion ID
     *
     * @param $id
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function status($id, Request $request)
    {
        $input = $request->all();

        $this->discussion->updateWithoutTags($id, $input);

        return $this->response->withNoContent();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        return $this->response->item($this->discussion->getById($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\DiscussionRequest  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(DiscussionRequest $request, $id)
    {
        $data = array_merge($request->all(), [
            'last_user_id' => \Auth::id()
        ]);

        $data['content'] = $data['content'];

        $this->discussion->update($id, $data);

        return $this->response->withNoContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->discussion->destroy($id);

        return $this->response->withNoContent();
    }
}
