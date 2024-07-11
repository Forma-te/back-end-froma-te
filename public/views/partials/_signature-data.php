<div class="signature-data">
    <div class="flex flex-row justify-start items-start w-full gap-x-3">
        <p>
            <span class="title">Transação Nº</span>
            <span class="data">{$signatureData->transactionNumber}</span>
        </p>

        <p>
            <span class="title">Plano</span>
            <span class="data">${$signatureData->plan}</span>
        </p>

        <p>
            <span class="title">Mensalidade</span>
            <span class="data">{$signatureData->months}</span>
        </p>

        <p>
            <span class="title">Preço Total</span>
            <span class="data">{$signatureData->price}</span>
        </p>

        <p>
            <span class="title">Data</span>
            <span class="data">{$signatureData->date}</span>
        </p>
    </div>
    
    <form 
        class="form flex flex-row justify-between items-end w-full"
        action="{{ route('signature.confirm', $signatureData->id) }}" method="POST"
    >
        <label for="expiry-date">
            <span>Data de vencimento</span>
            <input type="date" id="expiry-date" name="expiry-date"/>
        </label>

        <button type="button" class="fmt-button" data-styletype="primary" data-theme="light">
            Confirmar pagamento
        </button>
    </form>
</div>