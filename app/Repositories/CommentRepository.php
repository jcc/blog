<?php

namespace App\Repositories;

use App\Comment;
use App\Services\Mention;
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
    public function toggleVote($id)
    {
        $user = auth()->user();

        $comment = $this->getById($id);

        $hasVoted = $user->hasVoted($comment);

        $hasVoted ? $user->cancelVote($comment) : $user->upVote($comment);

        return $hasVoted;
    }

}
