<?php

namespace Mjex\Listeners;

use Mjex\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegisteredEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $user = $event->user;

        // Send activation email
        \Mail::send('emails.activate', ['user' => $user], function ($m) use ($user) {
            $m->to($user->email)->subject('Mjex Account activation');
        });


    }
}
