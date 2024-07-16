@extends('admin.templates.template-admin')

@section('contect')
<main id="menu-view" data-page="admin" data-view="signatures">
    <section id="signatures-menu" class="menu-container" data-active="true">
        <h3>Gestão de assinaturas solicitadas</h3>

        <section id="signatures-list" class="menu-area">
            <div class="w-full flex flex-row justify-start items-center mb-3 gap-x-2">
                <a id="signatures:signature-tab1" class="tab" data-active="true" href="{{ route('user.requests.all')}}"></a>

                <a id="signatures:requests-tab1" class="tab" data-active="false" href="{{ route('active.plans')}}"></a>
            </div>

            <div class="table-search">
                <i class="fa fa-search"></i>
                <input id="search-signature-table" name="search-key" type="text" />
            </div>

            <table class="fmt-table" id="signatures-table" data-styletype="primary" data-theme="light"
                data-hasview="true">
                <thead>
                    <tr>
                        <th id="email">E-mail produtor</th>
                        <th id="transaction">Transação Nº</th>
                        <th id="months">Mensalidade</th>
                        <th id="date">Data</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($requests->items() as $key => $request)
                    <tr id="signatures-table-row-1" data-tableid="signatures-table" data-id="1"
                        data-event="load-view">
                        <td data-tableid="signatures-table" data-id="1" class="email-col">{{ $request->email }}</td>
                        <td data-tableid="signatures-table" data-id="1" class="transaction-col">{{ $request->transaction }}</td>
                        <td data-tableid="signatures-table" data-id="1" class="months-col">{{ $request->quantity }}</td>
                        <td data-tableid="signatures-table" data-id="1" class="date-col">{{ $request->date }}
                        </td>
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>

            <div class="table-pagination">
                <span>A mostrar 2</span>

                <button type="button" class="ml-auto">
                    <i class="fa fa-arrow-left"></i>
                </button>

                <button type="button">1</button>

                <button type="button">2</button>

                <button type="button">3</button>

                <button type="button">4</button>

                <button type="button">
                    <i class="fa fa-arrow-right"></i>
                </button>
            </div>
        </section>
    </section>
</main>

@endsection
