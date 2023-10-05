<?php

namespace App\Listeners;

use App\Events\ReferralInvited;
use App\Actions\SendInviteAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendInvitation
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
     * @param  \App\Events\=ReferralInvited  $event
     * @return void
     */
    public function handle(ReferralInvited $event)
    {
        return (new SendInviteAction)($event->referral);
    }
}
