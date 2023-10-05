<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReferralInvitation extends Mailable
{
    use Queueable, SerializesModels;

    private $referral;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($referral)
    {
        $this->referral = $referral;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("{$this->referral['referral']['referrer']['name']} recommends ContactOut")
            ->markdown('emails.invitation', [
                'referral' =>  $this->referral
            ]);
    }
}
