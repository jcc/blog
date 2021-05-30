<?php

namespace App;

use App\Tools\Markdowner;
use App\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jcc\LaravelVote\Traits\Votable;

class Comment extends Model
{
    use SoftDeletes, Votable, BelongsToUser;

    protected $vote = User::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'commentable_id',
        'commentable_type',
        'content'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Get all of the owning commentable models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\morphTo
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Set the content Attribute.
     *
     * @param $value
     */
    public function setContentAttribute($value)
    {
        $data = [
            'raw' => $value,
            'html' => (new Markdowner)->convertMarkdownToHtml($value)
        ];

        $this->attributes['content'] = json_encode($data);
    }

}
