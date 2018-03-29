<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
            'content',
            'user_id',
            'post_id',
            'status'
        ];

    /* Save new comment
    *
    * @param array $comment
    * @return object Comment
    */
    public function saveComment($comment) {
        return $this->create($comment);
    }

    /*
     * Update comment
     */
    public function updateComment($comment) {
        return $this->create($comment);
    }

    /**
     * Get author of comment.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get comment of post.
     */
    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }

    /**
     * Get post comments.
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    
}
