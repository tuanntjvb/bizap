<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Models\Member;

class PasswordReset extends BaseMailer
{
    const MAIL_SUBJECT = 'Reset password';
    const BODY_TEMPLATE = 'emails.user.reset_password';

    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = $data;

        parent::__construct($this->data, self::BODY_TEMPLATE, self::MAIL_SUBJECT);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        parent::sendMail();
    }
}
