<?php

namespace App\Http\Controllers\Api;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $keyword = $request->get('keyword');

        $categories = Category::query()->when($keyword, function ($query) use ($keyword) {
            $query->where('name', 'like', "%{$keyword}%");
        })
            ->orderBy('created_at', 'desc')->paginate(10);

        return $this->response->collection($categories);
    }

    /**
     * Show all of the categories.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getList()
    {
        $categories = Category::all();

        return $this->response->collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\CategoryRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryRequest $request)
    {
        $category = new Category();
        $category->fill($request->all());
        $category->save();

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
        $input = $request->all();

        $category = Category::findOrFail($id);
        foreach ($input as $key => $value) {
            $category->{$key} = $value;
        }

        $category->save();

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
        $category = Category::findOrFail($id);

        return $this->response->item($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\CategoryRequest $request
     * @param int                                $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->fill($request->all());
        $category->save();

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
        Category::destroy($id);

        return $this->response->withNoContent();
    }
}
