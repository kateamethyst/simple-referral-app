<?php

namespace App\Providers;

use App\Events\UserRegistered;
use App\Events\ReferralInvited;
use App\Listeners\SetReferralStatus;
use App\Listeners\SendInvitation;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UserRegistered::class => [
            SetReferralStatus::class,
        ],
        ReferralInvited::class => [
            SendInvitation::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
