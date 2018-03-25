<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    public static function email($user_id)
    {
        $email = DB::table('users')
            ->leftJoin('posts', 'users.id', '=', 'posts.user_id')
            ->select('email')
            ->where('user_id', '=', $user_id)->get();

        return $email;

    }
}
