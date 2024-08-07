@component('mail::message')
# Olá, {{ $producer->name }}

Temos o prazer de informar que o seu pedido com a referência {{ $saleInstructor->transaction }} foi registado com sucesso!

No entanto, aguardamos a confirmação do pagamento para podermos avançar com o processamento.

Se já efetuou o pagamento, por favor, ignore este e-mail. Caso contrário, siga as instruções abaixo para concluir o processo:

# Detalhes para a transferência bancária:<br>
Assinatura: {{ $saleInstructor->plan->name }}<br>
Quantia: {{ number_format($saleInstructor->price, 2, ',', '.') }} Akz<br>
Titular da conta: {{ $company->name }}<br>
Detalhes da conta - {{ $company->bank }}<br>
Conta bancária - {{ $company->account }}<br>
IBAN/NIB - {{ $company->iban }}

Assim que o pagamento for confirmado, daremos seguimento ao processamento do seu pedido.

Se necessitar de assistência adicional ou tiver alguma dúvida, a nossa equipa de apoio está disponível para ajudar.

Por favor, envie o comprovativo de pagamento para o Whatsapp +244 921 271 191.

Obrigado por escolher a {{ config('app.name') }}!
@endcomponent
