<?php

namespace App\Repositories;

use App\Comment;
use App\Tools\Mention;
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
     * @param  boolean $isUpVote
     * 
     * @return boolean
     */
    public function toggleVote($id, $isUpVote = true)
    {
        $user = auth()->user();

        $comment = $this->getById($id);

        if($comment == null) {
            return false;
        }

        return $isUpVote
                ? $this->upOrDownVote($user, $comment)
                : $this->upOrDownVote($user, $comment, 'down');
    }

    /**
     * Up vote or down vote item.
     * 
     * @param  \App\User $user
     * @param  \Illuminate\Database\Eloquent\Model $target
     * @param  string $type
     * 
     * @return boolean
     */
    public function upOrDownVote($user, $target, $type = 'up')
    {
        $hasVoted = $user->{'has' . ucfirst($type) . 'Voted'}($target);

        if($hasVoted) {
            $user->cancelVote($target);
            return false;
        }

        if ($type == 'up') {
            $target->user->notify(new GotVote($type . '_vote', $user, $target));
        }

        $user->{$type . 'Vote'}($target);

        return true;
    }
}
