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

        $this->comment->toggleVote($request->id, true);

        return $this->noContent();
    }
    
    /**
     * post UpVote the comment by user.
     * 
     * @param  Request $request
     * @return mixed
     */
    public function postUpVoteComment(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:comments,id',
        ]);
        
        $this->comment->toggleVote($request->id, true);
        
        return $this->noContent();
    }
    
    
    /**
     * post DownVote the comment by user.
     * 
     * @param  Request $request
     * @return mixed
     */
    public function postDownVoteComment(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:comments,id',
        ]);
        
        $this->comment->toggleVote($request->id, false);
        
        return $this->noContent();
    }

}
