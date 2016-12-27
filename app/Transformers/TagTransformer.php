<?php

namespace App\Transformers;

use App\Tag;
use League\Fractal\TransformerAbstract;

class TagTransformer extends TransformerAbstract
{
    public function transform(Tag $tag)
    {
        return [
            'id'                => $tag->id,
            'tag'               => $tag->tag,
            'title'             => $tag->title,
            'meta_description'  => $tag->meta_description,
            'status'            => $tag->status,
            'created_at'        => $tag->created_at->toDateTimeString(),
        ];
    }
}
