<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Post extends Model
{
    use Sluggable;


     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'title',
            'content',
            'user_id'
        ];

    /**
     * Save new post
     *
     * @param array $post
     * @return object Post
     */
    public function savePost($post) {
        return $this->create($post);
    }

    /**
     * Update post
     *
     * @param array $post
     * @return void
     */
    public function updatePost($post) : void {
        $this->update($post);
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * Get author of post.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get post comments.
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment')->where('status', 1);
    }

    /**
     * Return comments count as singular or plural formatted string
     *
     * @return string
     */
    public function commentsCountFormatted()
    {
        $count = $this->comments()->count();
        return (($count === 0) ? 'No comments' : $count . (($count === 1) ? ' comment' : ' comments'));
    }
}
