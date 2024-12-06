<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class UserEncryptFacade extends Facade{
	protected static function getFacadeAccessor()
	{	
		return 'UserEncrypt';
	}
}