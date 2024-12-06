<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class UserTokenFacade extends Facade {
    protected static function getFacadeAccessor()
    {
        return 'UserToken';
    }
}