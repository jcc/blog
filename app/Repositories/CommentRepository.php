<?php

namespace App\Repositories;

use App\Comment;
use App\Services\Mention;
use App\Notifications\GotVote;
use App\Notifications\MentionedUser;

class CommentRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(Comment $comment)
    {
        $this->model = $comment;
    }

    /**
     * Store a new record.
     *
     * @param  $input
     * @return User
     */
    public function store($input)
    {
        $mention = new Mention();

        $input['content'] = $mention->parse($input['content']);

        $comment = $this->save($this->model, $input);

        foreach ($mention->users as $user) {
            $user->notify(new MentionedUser($comment));
        }

        return $comment;
    }

    /**
     * Save the input's data.
     *
     * @param  $model
     * @param  $input
     * @return User
     */
    public function save($model, $input)
    {
        $model->fill($input);

        $model->save();

        return $model;
    }

    /**
     * Get comments by the commentable_id and commentable_type
     * 
     * @param  int $commentableId
     * @param  string $commentableType
     * @return array
     */
    public function getByCommentable($commentableId, $commentableType)
    {
        return $this->model->where('commentable_id', $commentableId)
                    ->where('commentable_type', $commentableType)
                    ->get();
    }

    /**
     * Toogle up vote and down vote by user.
     * 
     * @param  int $id
     * @return boolean
     */
    public function toggleVote($id, $isUpVote)
    {
        $user = auth()->user();
        
        $comment = $this->getById($id);
        
        if($comment == null)
        {
            return false;
        }
        
        $hasVoted = $user->hasVoted($comment);
        
        $hasUpVoted = $user->hasUpVoted($comment);
        
        $hasDownVoted = $user->hasDownVoted($comment);
        
        if($hasVoted)
        {
            $user->cancelVote($comment);
        }
        
        if($isUpVote)
        {
            if($hasUpVoted)
            {
                return false;
            }
            
            $comment->user->notify(new GotVote('up_vote', $user, $comment));
            $user->upVote($comment);
            return true;
        }
        else 
        {
            if($hasDownVoted)
            {
                return false;
            }
            
            $comment->user->notify(new GotVote('down_vote', $user, $comment));
            $user->downVote($comment);
            return true;
        }
    }
}
