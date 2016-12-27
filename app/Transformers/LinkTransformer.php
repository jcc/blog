<?php

namespace App\Transformers;

use App\Link;
use League\Fractal\TransformerAbstract;

class LinkTransformer extends TransformerAbstract
{
    public function transform(Link $link)
    {
        return [
            'id'            => $link->id,
            'name'          => $link->name,
            'image'         => $link->image,
            'link'          => $link->link,
            'status'        => (bool) $link->status,
            'created_at'    => $link->created_at->toDateTimeString(),
        ];
    }
}
