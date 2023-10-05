<?php

namespace App\Actions;

use App\Models\Referral;

class SetReferralRegisteredAction
{
    /**
     * Set the status of the registered user
     */
    public function __invoke($user)
    {
        Referral::where('email', $user->email)
            ->update(['status' => Referral::REGISTERED]);
    }
}
