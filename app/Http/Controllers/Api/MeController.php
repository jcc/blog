<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Repositories\CommentRepository;

class MeController extends ApiController
{
    protected $comment;

    public function __construct(CommentRepository $comment)
    {
        $this->comment = $comment;
    }

    /**
     * post vote the comment by user.
     * 
     * @param  Request $request
     * @return mixed
     */
    public function postVoteComment(Request $request)
    {
        $this->validate($request, [
                'id' => 'required|exists:comments,id',
            ]);

        $this->comment->toggleVote($request->id);

        return $this->noContent();
    }

}
