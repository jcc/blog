<?php

namespace App\Http\Controllers\Api;

use App\Notifications\MentionedUser;
use App\Tools\Mention;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Notifications\ReceivedComment as Received;
use App\Comment;

class CommentController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        $commemts = Comment::query()->when($keyword, function ($query) use ($keyword) {
            $query->whereHas('user', function ($query) use ($keyword) {
                $query->where('name', 'like', "%{$keyword}%");
            });
        })
            ->orderBy('created_at', 'desc')->paginate(10);

        return $this->response->collection($commemts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CommentRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(CommentRequest $request)
    {
		$data = $request->all();

		if ($data['commentable_type'] === 'articles') {
			$article = \App\Article::find($data['commentable_id']);
			if (!auth()->user()->can('comment',$article)) return response()->json([],403);
		}

        $data['user_id'] = Auth::user()->id;

        $mention = new Mention();
        $data['content'] = $mention->parse($data['content']);

        $comment = Comment::create($data);
        foreach ($mention->users as $user) {
            $user->notify(new MentionedUser($comment));
        }
        $comment->commentable->user->notify(new Received($comment));

        return $this->response->item($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param int $commentableId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $commentableId)
    {
        $commentableType = $request->get('commentable_type');
        $commentsCount = $request->get('commentsCount');
        $comments = Comment::query()->where('commentable_id', $commentableId)
            ->where('commentable_type', $commentableType)
            ->paginate($commentsCount);

        return $this->response->collection($comments);
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
        return $this->response->item(Comment::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\CommentRequest $request
     * @param int                               $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(CommentRequest $request, $id)
    {
        $data = $request->all();

        Comment::findOrFail($id)->update($data);

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
        $comment = Comment::findOrFail($id);
        $this->authorize('delete', $comment);

        $comment->delete();

        return $this->response->withNoContent();
    }
}
