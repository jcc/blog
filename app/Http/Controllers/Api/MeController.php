<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Repositories\CommentRepository;

class MeController extends ApiController
{
    protected $comment;

    public function __construct(CommentRepository $comment)
    {
        parent::__construct();

        $this->comment = $comment;
    }

    /**
     * post up vote the comment by user.
     * 
     * @param Request $request
     * @param string $type
     * 
     * @return mixed
     */
    public function postVoteComment(Request $request, $type)
    {
        $this->validate($request, [
            'id' => 'required|exists:comments,id',
        ]);

        ($type == 'up')
            ? $this->comment->toggleVote($request->id)
            : $this->comment->toggleVote($request->id, false);
        
        return $this->response->withNoContent();
    }
}
