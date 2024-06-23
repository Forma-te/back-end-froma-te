<x-mail::message>
# Olá {{ $replySupport->support->user->name }}!

A sua questão relativa à aula {{ $replySupport->support->lesson->name }} foi respondida.

<x-mail::button :url="''">
Ver resposta
</x-mail::button>

Cumprimentos,<br>
{{ config('app.name') }}
</x-mail::message>
