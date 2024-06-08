<x-mail::message>
# Olá, {{ $member->name }}<br>
Boas notícias! O produto {{$course->name}}, está disponível.

# Dados de acesso:<br>
Usuário: {{$member->email}}<br>
Senha: {{$password}}

<x-mail::button :url="route('')">
Acesso à plataforma Forma-te
</x-mail::button>

Saudações,<br>
{{ config('app.name') }}
</x-mail::message>
