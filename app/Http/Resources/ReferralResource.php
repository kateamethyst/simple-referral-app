<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReferralResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'status' => $this->status,
            'referrer' => $this->referrer_id ? $this->when($this->referrer, [
                'id' => $this->referrer->id,
                'name' =>  $this->referrer->name,
                'email' => $this->referrer->email
            ]) : '',
            'code' => $this->code,
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
