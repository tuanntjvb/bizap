<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static int id()
 * @method static \Illuminate\Contracts\Auth\Authenticatable|null user()
 * @method static void logout()
 *
 * @see \App\Helpers\AuthAdminHelper
 */
class AuthAdmin extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'auth_admin_helper';
    }
}
