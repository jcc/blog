<?php
/*
 * This file is part of the overtrue/laravel-follow.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace App\Traits;

/**
 * Trait FollowTrait.
 */
trait FollowTrait
{
    /**
     * Follow a user or users.
     *
     * @param int|array $user
     *
     * @return int
     */
    public function follow($user)
    {
        return $this->followings()->sync((array)$user, false);
    }

    /**
     * Unfollow a user or users.
     *
     * @param int|array $user
     *
     * @return int
     */
    public function unfollow($user)
    {
        return $this->followings()->detach((array)$user);
    }

    /**
     * Check if user is following given user.
     *
     * @param $user
     *
     * @return bool
     */
    public function isFollowing($user)
    {
        return $this->followings->contains($user);
    }

    /**
     * Check if user is followed by given user.
     *
     * @param $user
     *
     * @return bool
     */
    public function isFollowedBy($user)
    {
        return $this->followers->contains($user);
    }

    /**
     * Return user followers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(__CLASS__, 'followers', 'follow_id', 'user_id')->withTimestamps();
    }

    /**
     * Return user following users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followings()
    {
        return $this->belongsToMany(__CLASS__, 'followers', 'user_id', 'follow_id')->withTimestamps();
    }
}