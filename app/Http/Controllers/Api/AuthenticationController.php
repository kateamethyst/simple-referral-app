<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Events\UserRegistered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use Illuminate\Http\Response;
use App\Actions\AttachRoleAction;
use App\Http\Resources\AuthenticatedUserResource;


class AuthenticationController extends Controller
{
    /**
     * Register user
     * 
     * @param  \App\Http\Requests\RegistrationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function register(RegistrationRequest $request)
    {
        try {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            (new AttachRoleAction)($user);

            if ($request->has('code')) {
                event(new UserRegistered($user));
            }

            return $this->successResponse(
                [
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'user' => new AuthenticatedUserResource($user),
                ],
                'User successfully registered.'
            );
        } catch(\Exception $e) {
            return $this->errorResponse(
                $e->getMessage() .
                'Oops! User failed to register.'
            );
        }
    }

    /**
     * Login user
     * 
     * @param  \App\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        try {
            if (!Auth::attempt($request->only(['email', 'password']))) {
                return $this->errorResponse(
                    'Invalid username or password.',
                    null,
                    [],
                    Response::HTTP_UNAUTHORIZED
                );
            }

            $user = User::where('email', $request->email)->firstOrFail();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => new AuthenticatedUserResource($user),
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Invalid username or password.'
            );
        }
    }

    /**
     * Logout user
     */
    public function logout()
    {
        try {
            request()->user()->currentAccessToken()->delete();

            return $this->successResponse(
                [],
                'User successfully logged out.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Oops! User failed to logout.'
            );
        }
    }
}
