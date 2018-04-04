<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class PendingComment extends Facade
{
    protected static function getFacadeAccessor() {
        return 'pendingcomment';
    }
}