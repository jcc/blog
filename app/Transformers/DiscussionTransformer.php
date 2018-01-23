<?php

namespace App\Transformers;

use App\Discussion;
use League\Fractal\TransformerAbstract;

class DiscussionTransformer extends TransformerAbstract
{
    protected $availableIncludes  = [
        'comments',
        'tags',
        'user'
    ];

    protected $defaultIncludes = [
        'user',
    ];

    public function transform(Discussion $discussion)
    {
        $content = json_decode($discussion->content);

        return [
            'id'            => $discussion->id,
            'user_id'       => $discussion->user_id,
            'title'         => $discussion->title,
            'content_raw'   => $content->raw,
            'status'        => (bool) $discussion->status,
            'comment_count' => $discussion->comments->count(),
            'created_at'    => $discussion->created_at->diffForHumans(),
        ];
    }

    /**
     * Include Comments
     *
     * @param Discussion $discussion
     * @return \League\Fractal\Resource\Collection
     */
    public function includeComments(Discussion $discussion)
    {
        if ($comments = $discussion->comments) {
            return $this->collection($comments, new CommentTransformer);
        }
    }

    /**
     * Include Comments
     *
     * @param Discussion $discussion
     * @return \League\Fractal\Resource\Collection
     */
    public function includeTags(Discussion $discussion)
    {
        if ($tags = $discussion->tags) {
            return $this->collection($tags, new TagTransformer);
        }
    }

    /**
     * Include User
     *
     * @param Discussion $discussion
     * @return \League\Fractal\Resource\Collection
     */
    public function includeUser(Discussion $discussion)
    {
        if ($user = $discussion->user) {
            return $this->item($user, new UserTransformer);
        }
    }
}
