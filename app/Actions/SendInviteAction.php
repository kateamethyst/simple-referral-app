<?php

namespace App\Actions;

use App\Models\Referral;
use App\Mail\ReferralInvitation;
use Illuminate\Support\Facades\Mail;

class SendInviteAction
{
    /**
     * Send referral invitation email to the referral
     */
    public function __invoke($referral)
    {
        Mail::to($referral->email)->send(new ReferralInvitation([
            'referral' => $referral
        ]));
    }
}
