<?php

namespace App\Services;

use App\Models\Post;
use Sentinel;

class PendingComment
{
    public function countComments($value = 2) {
            $user_id = Sentinel::getUser()->id;
            $count = Post::where('user_id', $user_id)
                    ->whereHas('pendingComments', function($q) use ($value) {
                        $q->where('status', $value);
                    })
                    ->count();

            return $count;
    }
}