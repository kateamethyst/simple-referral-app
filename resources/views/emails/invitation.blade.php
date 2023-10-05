@component('mail::message')
{{ $referral['referral']['referrer']['name'] }} has been using ContactOut, and thinks it could be of use for you.

Here’s their invitation link for you:
@component('mail::button', ['url' => "/register/?code={$referral['referral']['code']}", 'color' => 'success'])
Sign Up
@endcomponent

ContactOut gives you access to contact details for about 75% of the world’s professionals.

Great for recruiting, sales, and marketing outreach.

It’s an extension that works right on top of LinkedIn.

Here’s their invitation link again:
<a href="{{ url("/register/?code={$referral['referral']['code']}") }}" target="_blank">{{ url("/register/?code={$referral['referral']['code']}") }}</a>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
