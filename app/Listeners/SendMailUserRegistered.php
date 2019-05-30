<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Facades\SendMailFacade;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailUserRegistered implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        if (isset($event->temp_member)) {
            $mail = new \App\Mail\UserRegistered($event->user);
            $email = $event->user->email;

            SendMailFacade::sentMail($mail, $email);
        }
    }
}
