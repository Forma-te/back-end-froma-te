<h3>Listagem</h3>

<section id="producers-list" class="menu-area">
    <div class="w-full flex flex-row justify-start items-center mb-3 gap-x-2">
        <a id="producers:producers-tab" href="{{ url('/producers/list?page=1&quantity={$itemQuantity}') }}" class="tab" data-active="false">
            {{ $data->translation->producers_producerTab }}
        </a>

        <a id="producers:requests-tab" href="{{ url('/producers/requests?page=1&quantity={$itemQuantity}') }}" class="tab" data-active="true">
            {{ $data->translation->producers_requestsTab }}
        </a>
    </div>

    <form action="{{ route('producers.getMany') }}" method="POST">
        <div class="table-search">
            <i class="fa fa-search"></i>
            <input id="search-producers-requests-table" name="search-key" type="text" />
        </div>

        <table id="producers-requests-table" class="fmt-table" data-styletype="primary" data-theme="light" data-hasview="true">
            <thead>
                <tr>
                    <th id="name">Instrutor Nome</th>
                    <th id="request-date">Data de pedido</th>
                    <th id="type">Tipo</th>
                    <th id="request-email">E-mail</th>
                    <th id="actions">Ação</th>
                </tr>
            </thead>
    
            <tbody>
                @forelse ($producersPages as $producerRow) 
                    <tr id="{{"producers-requests-table-row-{$loop->index + 1}"}}" data-tableid="producers-requests-table" data-id="{{$loop->index + 1}}">
                        @foreach ($producerRow as $cell) 
                            @if($loop->index == (count($producerRow) - 1))
                                <td class="{{"{$cell}-col"}}">
                                    <button type="button" title="Aceitar pedido" class="fmt-button-circle" data-styletype="primary">
                                        <i class="fa fa-thumbs-up"></i>
                                    </button>

                                    <button type="button" title="Rejeitar pedido" class="fmt-button-circle" data-styletype="dangerous">
                                        <i class="fa fa-thumbs-down"></i>
                                    </button>
                                </th>
                            @else
                                <td class="{{"{$cell}-col"}}">{{$cell}}</th>
                            @endif
                        @endforeach
                    </tr>
                @empty
                    <tr id="producers-requests-table-row-1" data-tableid="producers-requests-table" data-id="1">
                        <td id="empty" colspan="6">
                            Sem pedidos de produtores
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="table-pagination">
            <span>A mostrar {{count($producersPages)}}</span>
            
            <a class="ml-auto" href="{{ url('/producers/requests?page=1&quantity={$itemQuantity}') }}">
                <i class="fa fa-arrow-left"></i>
            </a>

            <a href="{{ url('/producers/requests?page=1&quantity={$total}') }}">
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </form>
</section>