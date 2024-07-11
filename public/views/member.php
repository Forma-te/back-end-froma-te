<section id="member-registration" class="menu-area gap-y-2">
    <button id="member:create-member" data-event="toggle-form" data-targetid="create-member-form" type="button" class="w-full fmt-button" data-styletype="primary" data-theme="light">
        {{ $data->translation->members_createMember }}
    </button>

    <form id="create-member-form" class="section-form" data-toggled="false" action="{{ route('members.create') }}" method="POST">
    </form>
</section>

<h3>Listagem</h3>

<section id="members-list" class="menu-area">
    <form action="{{ route('members.getMany') }}" method="POST">
        <div class="table-search">
            <i class="fa fa-search"></i>
            <input id="search-members-table" name="search-key" type="text" />
        </div>

        <table id="members-table" class="fmt-table" data-styletype="primary" data-theme="light" data-hasview="true">
            <thead>
                <tr>
                    <th id="name">Nome</th>
                    <th id="email">E-mail</th>
                    <th id="actions">Ações</th>
                </tr>
            </thead>
    
            <tbody>
                @forelse ($membersPages as $memberRow) 
                    <tr id="{{"members-table-row-{$loop->index + 1}"}}" data-tableid="members-table" data-id="{{$loop->index + 1}}">
                        @foreach ($memberRow as $cell) 
                            @if($loop->index == (count($memberRow) - 1))
                                <td class="{{"{$cell}-col"}}">
                                    <button type="button" title="Eliminar membros" class="fmt-button-circle" data-styletype="dangerous">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </th>
                            @else
                                <td class="{{"{$cell}-col"}}">{{$cell}}</th>
                            @endif
                        @endforeach
                    </tr>
                @empty
                    <tr id="members-table-row-1" data-tableid="members-table" data-id="1">
                        <td id="empty" colspan="6">
                            Sem membros
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="table-pagination">
            <span>A mostrar {{count($membersPages)}}</span>
            
            <a class="ml-auto" href="{{ url('/members?page=1&quantity={$itemQuantity}') }}">
                <i class="fa fa-arrow-left"></i>
            </a>

            <a href="{{ url('/members?page=1&quantity={$total}') }}">
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </form>
</section>