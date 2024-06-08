<x-mail::message>
# Olá, {{ $member->name }}<br>
Boas notícias! O produto {{$course->name}}, está disponível.

<x-mail::button :url="route('')">
Acesso à plataforma Forma-te
</x-mail::button>

Saudações,<br>
{{ config('app.name') }}
</x-mail::message>
