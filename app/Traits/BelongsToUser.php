<?php

namespace App\Traits;

use App\User;

trait BelongsToUser
{
    /**
     * Get the user for the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function bootBelongsToUser()
    {
        static::saving(function ($model) {
            $model->user_id = $model->user_id ?? \Auth::id();
        });
    }
}