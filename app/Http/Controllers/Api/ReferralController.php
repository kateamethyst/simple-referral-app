<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Events\ReferralInvited;
use App\Models\Referral;
use App\Http\Resources\ReferralResource;
use Illuminate\Http\Request;
use App\Http\Requests\ReferralRequest;
use Illuminate\Support\Str;

class ReferralController extends Controller
{
    /**
     * Get all referrals
     */
    public function index()
    {
        try {
            $referrals = Referral::orderBy('created_at', 'desc')->paginate(10);

            return $this->successResourceResponse(
                ReferralResource::collection($referrals)
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to get referrals'
            );
        }
    }

    /**
     * Get all user's referral
     * @param $id Referred id
     */
    public function show()
    {
        try {
            $referrals = Referral::orderBy('created_at', 'desc')
                ->where('referrer_id', auth()->user()->id)
                ->paginate(10);

            return $this->successResourceResponse(
                ReferralResource::collection($referrals)
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to get referrals'
            );
        }
    }

    /**
     * Create referral
     */
    public function store(ReferralRequest $request)
    {
        try {
            foreach($request->emails as $email) {
                $referrals = Referral::create([
                    'email' => $email,
                    'referrer_id' => auth()->user()->id,
                    'status' => 'invited',
                    'code' => Str::random(40)
                ]);
    
                event(new ReferralInvited(Referral::with('referrer')
                    ->where('email', $email)
                    ->first()
                ));
            }

            $referrals = Referral::with('referrer')
                ->whereIn('email', $request->emails)
                ->get();

            return $this->successResourceResponse(
                ReferralResource::collection($referrals)
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage() .
                "Failed to send invite"
            );
        }
    }
}
