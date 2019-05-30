<?php

namespace App\Facades;

use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string getRandomString($length = 10, $type = ALPHANUM)
 * @method static array getAddressFromPostCode($postalCode)
 * @method static string removeWhiteSpace($inputString)
 *
 * @see \App\Helpers\StringHelper
 */
class StringFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'string_helper';
    }
}
