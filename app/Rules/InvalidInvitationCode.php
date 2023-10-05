<?php

namespace App\Rules;

use App\Models\Referral;
use Illuminate\Contracts\Validation\Rule;

class InvalidInvitationCode implements Rule
{
    public $email;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($email)
    { 
        $this->email = $email;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($value) {
            $referral = Referral::where('email', $this->email)->where('code', $value)->get();
            if ($referral->isEmpty()) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid referral code.';
    }
}
