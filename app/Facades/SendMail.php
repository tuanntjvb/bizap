<?php

namespace App\Facades;

use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool sentMail(Mailable $mail, $to, &$errMsg = '', $ccUsers = [], $bccUsers = [])
 *
 * @see \App\Helpers\SendMailHelper
 */
class SendMail extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'send_mail_helper';
    }
}
