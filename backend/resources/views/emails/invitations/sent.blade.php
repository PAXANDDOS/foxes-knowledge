@component('mail::message')
# {{ $user->name }} has invited you to join the Foxes Knowledge service

Hello, {{ $invitation->email }}. You have been invited to join the Foxes Knowledge service

@component('mail::panel')
Foxes Knowledge is a platform for sharing knowledge and connecting with other people
@endcomponent

Please click the button below to accept the invitation and proceed to registration

@component('mail::button', ['url' => $url])
Complete registration
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
