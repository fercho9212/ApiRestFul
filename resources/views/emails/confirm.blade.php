@component('mail::message')
# Introduction
Holaaa {{ $user->name }}
Gracias por utilizar nuestro servicio, por favor verifique el correo usando el siguiente enlace


@component('mail::button', ['url' => route('verify',$user->verification_token) ])
Cofirmar mi Cuenta
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
