<?php

namespace App;

use App\Services\Mention;
use App\Services\Markdowner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'commentable_id', 'commentable_type', 'content'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Get the user for the discussion comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

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
        $content = (new Mention)->parse($value);

        $data = [
            'raw'  => $content,
            'html' => (new Markdowner)->convertMarkdownToHtml($content)
        ];

        $this->attributes['content'] = json_encode($data);
    }

}
