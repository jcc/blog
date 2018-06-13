<?php

namespace App\Http\Controllers;

use App\Category;

class CategoryController extends Controller
{
    /**
     * Display the categories resource.
     *
     * @return mixed
     */
    public function index()
    {
        $categories = Category::query()->get();

        return view('category.index', compact('categories'));
    }

    /**
     * Display the category resource by category name.
     *
     * @param string $category
     *
     * @return mixed
     */
    public function show($category)
    {
        $category = Category::query()->where('name', $category)->first();

        if (!$category) {
            abort(404);
        }

        $articles = $category->articles;

        return view('category.show', compact('category', 'articles'));
    }
}
