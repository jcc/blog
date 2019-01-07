<?php

namespace App\Http\Controllers\Api;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\TagRequest;

class TagController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $keyword = $request->get('keyword');

        $tags = Tag::query()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('tag', 'like', "%{$keyword}%")
                    ->orWhere('title', 'like', "%{$keyword}%");
            })
            ->orderBy('created_at', 'desc')->paginate(10);

        return $this->response->collection($tags);
    }

    /**
     * Show all of the tags.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getList()
    {
        return $this->response->collection(Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\TagRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TagRequest $request)
    {
        Tag::create($request->all());

        return $this->response->withNoContent();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        return $this->response->item(Tag::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        Tag::findOrFail($id)->update($request->except('tag'));

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
        Tag::destroy($id);

        return $this->response->withNoContent();
    }
}
