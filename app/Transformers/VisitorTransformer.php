<?php

namespace App\Transformers;

use App\Visitor;
use League\Fractal\TransformerAbstract;

class VisitorTransformer extends TransformerAbstract
{
    public function transform(Visitor $visitor)
    {
        return [
            'id'            => $visitor->id,
            'article'       => [ 'title' => isset($visitor->article) ? $visitor->article->title : 'null' ],
            'ip'            => $visitor->ip,
            'country'       => $visitor->country,
            'clicks'        => $visitor->clicks,
            'created_at'    => $visitor->created_at->toDateTimeString(),
        ];
    }
}
