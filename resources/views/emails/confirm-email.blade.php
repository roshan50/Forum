@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => url('/register/confirm?token='.$user->confirmation_token)])
confirm button
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
