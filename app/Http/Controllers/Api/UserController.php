<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Return authenticated user
     */
    public function me()
    {
        try {
            $user = User::find(auth()->user()->id);

            return $this->successResourceResponse(
                new UserResource($user)
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to get user'
            );
        }
    }
}
