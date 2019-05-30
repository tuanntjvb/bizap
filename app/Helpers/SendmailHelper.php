<?php

namespace App\Helpers;

use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMailHelper
{

    /**
     * Send mail with catch exception
     * @param Mailable $mail
     * @param string $to
     * @param string &$errMsg
     * @param array $ccUsers
     * @param array $bccUsers
     * @return bool
     *
     * @throws \Exception
     */
    public static function sentMail(Mailable $mail, $to, &$errMsg = '', $ccUsers = [], $bccUsers = [])
    {
        if (!empty($to)) {
            try {
                if (config('app.debug')) {
                    //Todo: push cc mail here
                }

                Mail::to($to)
                    ->cc($ccUsers)
                    ->bcc($bccUsers)
                    ->send($mail);

                Log::info('Mail was sent to ' . $to);

                return self::isSent($errMsg);
            } catch (\Exception $exception) {
                Log::error($exception);

                throw $exception;
            }
        }
    }

    /**
     * Check mail is sent
     * @param string &$errMsg
     * @return bool
     *
     * @throws \Exception
     */
    private static function isSent(&$errMsg = '')
    {
        try {
            $errors = Mail::failures();

            if (count($errors) > 0) {
                $errMsg = 'Sending mail was one or more failures. They were: <br />';
                foreach ($errors as $email_address) {
                    $errMsg .= " - $email_address <br />";
                }

                Log::error($errMsg);
                return false;
            }
        } catch (\Exception $exception) {
            $errMsg = $exception->getMessage();
            Log::error($errMsg);

            throw $exception;
        }

        return true;
    }
}
