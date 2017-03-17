<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    /**
     * Display the categories resource.
     * 
     * @return mixed
     */
    public function index()
    {
        $categories = $this->category->all();

        return view('category.index', compact('categories'));
    }

    /**
     * Display the category resource by category name.
     * 
     * @param  string $category
     * @return mixed
     */
    public function show($category)
    {
        if (!$category = $this->category->getByName($category)) abort(404);

        $articles = $category->articles;

        return view('category.show', compact('category', 'articles'));
    }
}
