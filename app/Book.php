<?php

namespace App;

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
    protected $dates = ['deleted_at'];

    
    protected $guarded = [];

    /**
     * checkAuth
     * @param $query
     * @return mixed
     */
    public function scopeCheckAuth($query)
    {
        if (auth()->check() && auth()->user()->is_admin) {
            $query->withoutGlobalScope(DraftScope::class);
        }
        return $query;
    }
   
    
}
