<?php

namespace App\Models;

use Cartalyst\Sentinel\Users\EloquentUser;

class User extends EloquentUser
{
    /**
     * Get user's posts.
     */
    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }

    /**
     * Get post comments.
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }
}
