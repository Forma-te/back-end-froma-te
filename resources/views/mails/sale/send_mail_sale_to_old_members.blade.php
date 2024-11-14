<x-mail::message>
# Olá, {{ $member->name }}<br>
Boas notícias! O produto {{$product->name}}, está disponível.

<x-mail::button :url="''">
Acesso à plataforma Forma-te
</x-mail::button>

Saudações,<br>
{{ config('app.name') }}
</x-mail::message>
