@component('mail::message')
# Introduction
Holaaa {{ $user->name }}
Gracias por utilizar nuestro servicio, Verifique el siguiente enlace

@component('mail::button', ['url' => route('verify',$user->verification_token) ])
Confrimar mi Cuenta
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
