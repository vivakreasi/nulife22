@component('mail::message')

<h2 style='font-size: 24px;'>Reset your password?</h2>
If you requested a password reset for {{$data['dataNewMember']['email']}}, click the button below. <br>
If you didn't make this request, ignore this email.

@component('mail::button', ['url' => route('home').'/password/activation/'.$data['url']])
Reset password
@endcomponent

This link will not active in 2 x 24 hours
@endcomponent
