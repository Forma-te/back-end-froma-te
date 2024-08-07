<h3>Listagem</h3>

<section id="producers-list" class="menu-area">
    <div class="w-full flex flex-row justify-start items-center mb-3 gap-x-2">
        <a id="producers:producers-tab" href="{{ url('/producers/list?page=1&quantity={$itemQuantity}') }}" class="tab" data-active="true">
            {{ $data->translation->producers_producerTab }}
        </a>

        <a id="producers:requests-tab" href="{{ url('/producers/requests?page=1&quantity={$itemQuantity}') }}" class="tab" data-active="false">
            {{ $data->translation->producers_requestsTab }}
        </a>
    </div>

    <form action="{{ route('producers.getMany') }}" method="POST">
        <div class="table-search">
            <i class="fa fa-search"></i>
            <input id="search-producers-table" name="search-key" type="text" />
        </div>

        <table id="producers-table" class="fmt-table" data-styletype="primary" data-theme="light" data-hasview="true">
            <thead>
                <tr>
                    <th id="name">Instrutor Nome</th>
                    <th id="courses">Cursos</th>
                    <th id="students">Total Estudantes</th>
                    <th id="actions">Ação</th>
                </tr>
            </thead>
    
            <tbody>
                @forelse ($producersPages as $producerRow) 
                    <tr id="{{"producers-table-row-{$loop->index + 1}"}}" data-tableid="producers-table" data-id="{{$loop->index + 1}}">
                        @foreach ($producerRow as $cell) 
                            @if($loop->index == (count($producerRow) - 1))
                                <td class="{{"{$cell}-col"}}">
                                    <button type="button" title="Eliminar Instrutor" class="fmt-button-circle" data-styletype="dangerous">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </th>
                            @else
                                <td class="{{"{$cell}-col"}}">{{$cell}}</th>
                            @endif
                        @endforeach
                    </tr>
                @empty
                    <tr id="producers-table-row-1" data-tableid="producers-table" data-id="1">
                        <td id="empty" colspan="6">
                            Sem produtores
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="table-pagination">
            <span>A mostrar {{count($producersPages)}}</span>
            
            <a class="ml-auto" href="{{ url('/producers/list?page=1&quantity={$itemQuantity}') }}">
                <i class="fa fa-arrow-left"></i>
            </a>

            <a href="{{ url('/producers/list?page=1&quantity={$total}') }}">
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </form>
</section>