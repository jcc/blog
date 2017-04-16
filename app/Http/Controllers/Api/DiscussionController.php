<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\DiscussionRequest;
use App\Repositories\DiscussionRepository;
use App\Transformers\DiscussionTransformer;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->respondWithPaginator($this->discussion->page(10, 'desc'), new DiscussionTransformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\DiscussionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiscussionRequest $request)
    {
        $data = array_merge($request->all(), [
            'user_id'      => \Auth::id(),
            'last_user_id' => \Auth::id()
        ]);

        $this->discussion->store($data);

        return $this->noContent();
    }

    /**
     * Update Discussion Status By Discussion ID
     *
     * @param $id
     * @param Request $request
     * @return \App\User
     */
    public function status($id, Request $request)
    {
        $input = $request->all();

        $this->discussion->updateWithoutTags($id, $input);

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
        return $this->respondWIthItem($this->discussion->getById($id), new DiscussionTransformer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\DiscussionRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DiscussionRequest $request, $id)
    {
        $data = array_merge($request->all(), [
            'last_user_id' => \Auth::id()
        ]);

        $this->discussion->update($id, $data);

        return $this->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->discussion->destroy($id);

        return $this->noContent();
    }
}
