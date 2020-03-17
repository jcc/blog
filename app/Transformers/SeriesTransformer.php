<?php

namespace App\Transformers;

use App\Series;
use League\Fractal\TransformerAbstract;

class SeriesTransformer extends TransformerAbstract
{
    protected $availableIncludes  = [];

    public function transform(Series $series)
    {
        return [
            'id'                => $series->id,
            'name'             => $series->name,
            'created_at'      => $series->created_at->diffForHumans(),
            'updated_at'    => $series->updated_at->toDateTimeString(),
        ];
    }

}
