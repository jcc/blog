<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Repositories\TagRepository;

class TagController extends Controller
{
    protected $tag;

    public function __construct(TagRepository $tag)
    {
        $this->tag = $tag;
    }

    /**
     * Display the tag resource.
     * 
     * @return mixed
     */
    public function index()
    {
        $tags = $this->tag->all();

        return view('tag.index', compact('tags'));
    }

    /**
     * Display the articles and discussions by the tag.
     * 
     * @param  string $tag
     * @return mixed
     */
    public function show($tag)
    {
        $tag = $this->tag->getByName($tag);

        if (!$tag) abort(404);

        $articles = $tag->articles;
        $discussions = $tag->discussions;

        return view('tag.show', compact('tag', 'articles', 'discussions'));
    }
}
