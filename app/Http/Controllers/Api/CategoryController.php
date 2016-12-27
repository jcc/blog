<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Repositories\CategoryRepository;
use App\Transformers\CategoryTransformer;

class CategoryController extends ApiController
{
    protected $category;

    public function __construct(CategoryRepository $category)
    {
        parent::__construct();

        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->respondWithPaginator($this->category->page(), new CategoryTransformer);
    }

    /**
     * Show all of the categories.
     *
     * @return mixed
     */
    public function getList()
    {
        return $this->respondWithCollection($this->category->all(), new CategoryTransformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $this->category->store($request->all());

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

        $this->category->updateColumn($id, $input);

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
        return $this->respondWithItem($this->category->getById($id), new CategoryTransformer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $this->category->update($id, $request->all());

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
        $this->category->destroy($id);

        return $this->noContent();
    }
}
