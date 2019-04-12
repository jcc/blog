<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Scopes\DraftScope;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;

class ArticleController extends ApiController
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
        $articles = Article::checkAuth()->filter($request->all())->orderBy('created_at', 'desc')->paginate(10);

        return $this->response->collection($articles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\ArticleRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ArticleRequest $request)
    {
        $data = array_merge($request->all(), [
            'user_id' => \Auth::id(),
            'last_user_id' => \Auth::id(),
        ]);

        $data['is_draft'] = isset($data['is_draft']);
        $data['is_original'] = isset($data['is_original']);

        $article = new Article();
        $article->fill($data);
        $article->save();

        $article->tags()->sync(json_decode($request->get('tags')));

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
        $article = Article::withoutGlobalScope(DraftScope::class)->findOrFail($id);

        return $this->response->item($article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\ArticleRequest $request
     * @param int                               $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ArticleRequest $request, $id)
    {
        $data = array_merge($request->all(), [
            'last_user_id' => \Auth::id(),
        ]);
        $article = Article::withoutGlobalScope(DraftScope::class)->findOrFail($id);
        $article->update($data);

        $article->tags()->sync(json_decode($request->get('tags')));

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
        Article::withoutGlobalScope(DraftScope::class)->findOrFail($id)->delete();

        return $this->response->withNoContent();
    }
}
