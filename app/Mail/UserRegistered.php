<?php

namespace App\Mail;

use App\Models\Temporarily;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class UserRegistered extends BaseMailer
{
    const MAIL_SUBJECT = 'User registered';
    const BODY_TEMPLATE = 'emails.user.registered';

    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->data = [
            'user' => $user
        ];

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
