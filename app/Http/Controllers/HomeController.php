<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class HomeController extends Controller
{
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
     * @param Request $request
     *
     * @return mixed
     */
    public function search(Request $request)
    {
        $key = trim($request->get('q'));

        $articles = Article::query()->where('title', 'like', "%{$key}%")
            ->orderBy('published_at', 'desc')
            ->get();

        return view('search', compact('articles'));
    }
}
