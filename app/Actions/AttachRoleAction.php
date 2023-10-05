<?php

namespace App\Actions;

use App\Models\Role;
use App\Models\UserRole;
use App\Mail\ReferralInvitation;
use Illuminate\Support\Facades\Mail;

class AttachRoleAction
{
    /**
     * Attach user role to registered user
     */
    public function __invoke($user)
    {
        $role = Role::where('slug', 'user')->firstOrFail();

        UserRole::create([
            'user_id' => $user->id,
            'role_id' => $role->id
        ]);
    }
}
