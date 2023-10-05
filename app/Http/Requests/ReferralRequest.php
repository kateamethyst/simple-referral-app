<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UserAlreadyInvited;
use App\Rules\MaxInvitation;

class ReferralRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'emails.*' => ['required', 'email', 'unique:users,email', new UserAlreadyInvited],
            'referrer_id' => ['required', 'exists:users,id', new MaxInvitation],
        ];
    }
}
