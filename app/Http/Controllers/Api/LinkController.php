<?php

namespace App\Http\Controllers\Api;

use App\Link;
use App\Scopes\StatusScope;
use Illuminate\Http\Request;
use App\Http\Requests\LinkRequest;

class LinkController extends ApiController
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
        $links = Link::checkAuth()->filter($request->all())->orderBy('created_at', 'desc')->paginate(10);

        return $this->response->collection($links);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\LinkRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LinkRequest $request)
    {
        $data = $request->all();

        $data['status'] = isset($data['status']);

        Link::create($data);

        return $this->response->withNoContent();
    }

    /**
     * Update Link Status By Link ID.
     *
     * @param $id
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function status($id, Request $request)
    {
        $input = $request->all();

        $link = Link::withoutGlobalScope(StatusScope::class)->findOrFail($id);
        $link->update($input);

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
        $link = Link::checkAuth()->findOrFail($id);

        return $this->response->item($link);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\LinkRequest $request
     * @param int                            $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(LinkRequest $request, $id)
    {
        Link::checkAuth()->findOrFail($id)->update($request->all());

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
        Link::checkAuth()->findOrFail($id)->delete();

        return $this->response->withNoContent();
    }
}
