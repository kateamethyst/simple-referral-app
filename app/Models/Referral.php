<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    public CONST REGISTERED = 'registered';
    public CONST INVITED = 'invited';
    public CONST LIMIT = 10;

    protected $fillable = [
        'email',
        'referrer_id',
        'code',
        'status',
    ];

    /**
     * Related model to Referral
     */
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }
}
