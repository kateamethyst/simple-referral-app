<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Actions\SetReferralRegisteredAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetReferralStatus
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\=UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        return (new SetReferralRegisteredAction)($event->user);
    }
}
