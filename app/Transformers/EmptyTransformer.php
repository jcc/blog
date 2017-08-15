<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class EmptyTransformer extends TransformerAbstract
{
    /**
     * Transform a collection.
     *
     * @return array
     */
    public function transform()
    {
        return [];
    }
}