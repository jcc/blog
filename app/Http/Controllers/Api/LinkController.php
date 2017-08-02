<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\LinkRequest;
use App\Repositories\LinkRepository;

class LinkController extends ApiController
{
    protected $link;

    protected $manager;

    public function __construct(LinkRepository $link)
    {
        parent::__construct();

        $this->link = $link;

        $this->manager = app('uploader');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->response->collection($this->link->page());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\LinkRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LinkRequest $request)
    {
        $data = $request->all();

        $data['status'] = isset($data['status']);

        $this->link->store($data);

        return $this->response->withNoContent();
    }

    /**
     * Update Link Status By Link ID
     *
     * @param $id
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function status($id, Request $request)
    {
        $input = $request->all();

        $this->link->update($id, $input);

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
        return $this->response->item($this->link->getById($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\LinkRequest  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(LinkRequest $request, $id)
    {
        $this->link->update($id, $request->all());

        return $this->response->withNoContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->link->destroy($id);

        return $this->response->withNoContent();
    }
}
