<h3>Gestão de assinaturas solicitadas</h3>
    
<section id="signatures-list" class="menu-area">
    <div class="w-full flex flex-row justify-start items-center mb-3 gap-x-2">
        <a id="signatures:signature-tab" href="{{ url('/signatures/list?page=1&quantity={$itemQuantity}') }}" class="tab" data-active="false">
            {{ $data->translation->signatures_signatureTab }}
        </a>

        <a id="signatures:requests-tab" href="{{ url('/signatures/requests?page=1&quantity={$itemQuantity}') }}" class="tab" data-active="true">
            {{ $data->translation->signatures_requestsTab }}
        </a>
    </div>

    <form action="{{ route('signatures.getMany') }}" method="POST">
        <div class="table-search">
            <i class="fa fa-search"></i>
            <input id="search-signature-table" name="search-key" type="text" />
        </div>
    
        <table id="signature-requests-table" class="fmt-table" data-styletype="primary" data-theme="light" data-hasview="true">
            <thead>
                <tr>
                    <th id="email">E-mail instrutor</th>
                    <th id="months">Mensalidade</th>
                    <th id="initDate">Data Início</th>
                    <th id="renwDate">Data Renovação</th>
                    <th id="status">Estado</th>
                </tr>
            </thead>
    
            <tbody>
                @forelse ($signaturesPages as $signatureRow) 
                    <tr id="{{"signature-requests-table-row-{$loop->index + 1}"}}" data-tableid="signature-requests-table" data-id="{{$loop->index + 1}}">
                        @foreach ($signatureRow as $cell) 
                            @if($loop->index == (count($signatureRow) - 1))
                                <td class="{{"{$cell}-col"}}">
                                    @switch($cell)
                                        @case('approved')
                                            <span class="fmt-tag" data-styletype="approved">Aprovado</span>
                                        @break

                                        @case('denied')
                                            <span class="fmt-tag" data-styletype="dangerous">Rejeitado</span>
                                        @break

                                        @default <span class="fmt-tag" data-styletype="warning">Em Espera</span>
                                    @endswitch
                                </th>
                            @else
                                <td class="{{"{$cell}-col"}}">{{$cell}}</th>
                            @endif
                        @endforeach
                    </tr>
                @empty
                    <tr id="signature-requests-table-row-1" data-tableid="signature-requests-table" data-id="1">
                        <td id="empty" colspan="6">
                            Sem pedidos de assinaturas
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    
        <div class="table-pagination">
            <span>A mostrar {{count($signaturesPages)}}</span>
    
            <a class="ml-auto" href="{{ url('/signatures/requests?page=1&quantity={$itemQuantity}') }}">
                <i class="fa fa-arrow-left"></i>
            </a>
    
            <a href="{{ url('/signatures/requests?page=1&quantity={$total}') }}">
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </form>
</section>