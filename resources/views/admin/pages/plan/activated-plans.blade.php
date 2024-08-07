@extends('admin.templates.template-admin')

@section('contect')
<main id="menu-view" data-page="admin" data-view="producers">
    <section id="producers-requests-menu" class="menu-container" data-active="true">
        <h3>Listagem</h3>

        <section id="producers-requests-list" class="menu-area">
            <div class="w-full flex flex-row justify-start items-center mb-3 gap-x-2">
                <a id="producers:producers-tab1" class="tab" data-active="false" href="{{ route('user.requests.all')}}"></a>

                <a id="producers:requests-tab1" class="tab" data-active="true" href="{{ route('active.plans')}}"></a>
            </div>

            <div class="table-search">
                <i class="fa fa-search"></i>
                <input id="search-signature-table" name="search-key" type="text" />
            </div>

            <table class="fmt-table" id="signature-requests-table" data-styletype="primary" data-theme="light"
                data-hasview="false">
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
                    @forelse($activePlans->items() as $key => $activePlan)
                    <tr id="signature-requests-table-row-1" data-tableid="signature-requests-table" data-id="1">
                        <td data-tableid="signature-requests-table" data-id="1" class="email-col">
                            {{ $activePlan->email }}</td>
                        <td data-tableid="signature-requests-table" data-id="1" class="months-col">{{ $activePlan->quantity }}</td>
                        <td data-tableid="signature-requests-table" data-id="1" class="initDate-col">{{ $activePlan->date_start }}</td>
                        <td data-tableid="signature-requests-table" data-id="1" class="renwDate-col">{{ $activePlan->date_the_end }}</td>
                        <td data-tableid="signature-requests-table" data-id="1" class="status-col"><span
                                class="fmt-tag" data-styletype="approved">{{ $activePlan->status }}</span>
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
