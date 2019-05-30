<?php
/**
 * Auth Admin Helper
 * User: TrinhNV
 * Date: 8/24/2018
 * Time: 3:55 PM
 */

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class AuthAdminHelper
{
    /**
     * Get current admin id
     * @return int|null
     */
    public static function id()
    {
        return self::guard()->id();
    }

    /**
     * Get current admin
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public static function user()
    {
        return self::guard()->user();
    }

    /**
     * Get current admin
     * return void
     */
    public static function logout()
    {
        return self::guard()->logout();
    }

    /**
     * @return Auth
     */
    private static function guard()
    {
        return Auth::guard(ADMIN_GUARD);
    }

}
