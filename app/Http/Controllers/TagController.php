<?php

namespace App\Http\Controllers;

use App\Tag;

class TagController extends Controller
{
    /**
     * Display the tag resource.
     *
     * @return mixed
     */
    public function index()
    {
        $tags = Tag::query()->get();

        return view('tag.index', compact('tags'));
    }

    /**
     * Display the articles and discussions by the tag.
     *
     * @param string $tag
     *
     * @return mixed
     */
    public function show($tag)
    {
        $tag = Tag::query()->where('tag', $tag)->first();

        if (!$tag) {
            abort(404);
        }

        $articles = $tag->articles;
        $discussions = $tag->discussions;

        return view('tag.show', compact('tag', 'articles', 'discussions'));
    }
}
