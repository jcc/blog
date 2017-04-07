<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use App\Repositories\ArticleRepository;
use App\Transformers\ArticleTransformer;
use App\Services\FileManager\UploadManager;

class ArticleController extends ApiController
{
    protected $article;

    public function __construct(ArticleRepository $article, UploadManager $manager)
    {
        parent::__construct();

        $this->article = $article;
        $this->manager = $manager;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->respondWithPaginator($this->article->page(), new ArticleTransformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ArticleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $data = array_merge($request->all(), [
            'user_id'      => \Auth::id(),
            'last_user_id' => \Auth::id()
        ]);

        $data['is_draft']    = isset($data['is_draft']);
        $data['is_original'] = isset($data['is_original']);

        $this->article->store($data);

        $this->article->syncTag(json_decode($request->get('tags')));

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
        return $this->respondWithItem($this->article->getById($id), new ArticleTransformer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ArticleRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, $id)
    {
        $data = array_merge($request->all(), [
            'last_user_id' => \Auth::id()
        ]);

        $this->article->update($id, $data);

        $this->article->syncTag(json_decode($request->get('tags')));

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
        $this->article->destroy($id);

        return $this->noContent();
    }

    public function uploadPaste(Request $request)
    {
        // $fileName = $_POST;
        $file = $request->file('file');
        // var_dump($request->file('file'));die;
        $validator = \Validator::make([ 'file' => $file ], [ 'file' => 'image' ]);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->getMessageBag()->toArray()
            ]);
        }

        $path = 'images/' . date("Y") . '/' . date("m") . '/' . date("d") . '/' . uniqid();

        $result = $this->manager->store($file, $path);

        return $this->respondWithArray($result);
    }
}
