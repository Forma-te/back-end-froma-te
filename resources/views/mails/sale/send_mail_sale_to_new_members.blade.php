<x-mail::message>
# Olá, {{ $member->name }}<br>
Bem-vindo a Forma-te.

# Seus dados de acesso a Forma-te:<br>
Usuário: {{$member->email}}<br>
Senha: {{$password}}

<x-mail::button :url="''">
Acesso à plataforma Forma-te
</x-mail::button>

Saudações,<br>
{{ config('app.name') }}
</x-mail::message>
