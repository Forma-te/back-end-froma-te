<x-mail::message>
# Olá, {{ $saleSubscription->producer->name }}<br>

É com prazer que informamos que agora está oficialmente habilitado(a) a explorar
<br>
todo o potencial que a plataforma oferece.

A sua assinatura termina em: {{ $saleSubscription->date_the_end }}

<x-mail::button :url="''">
    Aceder à plataforma Forma-te
</x-mail::button>

Cumprimentos,<br>
{{ config('app.name') }}
</x-mail::message>
