<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BaseMailer extends Mailable
{
    const SUBJECT_PREFIX = '【SiteName】 ';

    use Queueable, SerializesModels;

    /**
     * The shop instance.
     *
     * @var array
     */
    public $data;

    public $title;

    public $templateId;

    public $bodyTemplate;

    public $mail_config;


    /**
     * Create a new message instance.
     *
     */
    public function __construct(array $data, $bodyTemplate, $subject = null)
    {
        $this->data = $data;

        $this->bodyTemplate = $bodyTemplate;

        $this->title = self::SUBJECT_PREFIX . ($subject ?? '');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function sendMail()
    {
        $this->subject($this->title)
            ->with($this->data)
            ->view($this->bodyTemplate)
            ->withSwiftMessage(function ($message) {
                $message->getHeaders()->addTextHeader('Return-Path', env('RETURN_PATH'));
            });
    }
}
