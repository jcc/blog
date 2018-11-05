<?php

namespace App;

use App\Scopes\DraftScope;
use App\Tools\Markdowner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['published_at', 'created_at', 'deleted_at'];

    
    protected $guarded = [];


   
    
}
