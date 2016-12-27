<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Repositories\ArticleRepository;

class HomeController extends Controller
{
    protected $article;

    public function __construct(ArticleRepository $article)
    {
        $this->article = $article;
    }

    /**
     * Display the dashboard page.
     * 
     * @return mixed
     */
    public function dashboard()
    {
        return view('dashboard.index');
    }

    /**
     * Search the article by keyword.
     * 
     * @param  Request $request
     * @return mixed
     */
    public function search(Request $request)
    {
        $key = trim($request->get('q'));

        $articles = $this->article->search($key);

        return view('search', compact('articles'));
    }
}
