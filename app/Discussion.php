<?php

namespace App;

use App\Scopes\StatusScope;
use App\Tools\Markdowner;
use App\Traits\BelongsToUser;
use App\Traits\HasComments;
use App\Traits\HasTags;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discussion extends Model
{
    use SoftDeletes, BelongsToUser, HasComments, HasTags;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'last_user_id',
        'title',
        'content',
        'status'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new StatusScope());
    }

    /**
     * Set the content attribute.
     *
     * @param $value
     */
    public function setContentAttribute($value)
    {
        $data = [
            'raw'  => $value,
            'html' => (new Markdowner)->convertMarkdownToHtml($value)
        ];

        $this->attributes['content'] = json_encode($data);
    }

    /**
     * checkAuth
     *
     * @author Huiwang <905130909@qq.com>
     *
     * @param $query
     * @return mixed
     */
    public function scopeCheckAuth($query)
    {
        if (auth()->check() && auth()->user()->is_admin) {
            $query->withoutGlobalScope(StatusScope::class);
        }
        return $query;
    }
}
