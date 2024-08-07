@extends('admin.templates.template-admin')

@section('contect')
<main id="menu-view" data-page="admin" data-view="producers">
    <section id="producers-menu" class="menu-container" data-active="true">
        <h3>Listagem</h3>

        <section id="producers-list" class="menu-area">
            <div class="w-full flex flex-row justify-start items-center mb-3 gap-x-2">
                <a id="producers:producers-tab1" class="tab" data-active="true" href="./admin-producers.html"></a>

                <a id="producers:requests-tab1" class="tab" data-active="false" href="./admin-producers-requests.html"></a>
            </div>

            <div class="table-search">
                <form method="GET" action="{{ route('get.producers') }}">
                    <i class="fa fa-search"></i>
                    <input id="search-producers-table" name="filter" type="text" value="{{ request('filter') }}" />
                    <button type="submit"></button>
                </form>
            </div>

            <table id="producers-table" class="fmt-table" data-styletype="primary" data-theme="light"
                data-hasview="true">
                <thead>
                    <tr>
                        <th id="name">Instrutor Nome</th>
                        <th id="courses">Cursos</th>
                        <th id="students">Total Estudantes</th>
                        <th id="actions">Ação</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ( $producers as $producer)
                    <tr id="producers-table-row-1" data-tableid="producers-table" data-id="1" data-event="load-view">
                        <td data-tableid="producers-table" data-id="{{ $loop->iteration }}" class="name-col">{{ $producer->name }}</td>
                        <td data-tableid="producers-table" data-id="{{ $loop->iteration }}" class="cursos-col">{{ $producer->coursesProducer->count() }}</td>
                        <td data-tableid="producers-table" data-id="{{ $loop->iteration }}" class="students-col">{{ $producer->student->count() }}</td>
                        <td data-tableid="producers-table" data-id="{{ $loop->iteration }}" class="actions-col">
                            <button type="button" title="Eliminar Instrutor" data-id="gfagagfhrt+"
                                data-action="delete" data-entity="producer" data-event="api"
                                class="fmt-button-circle" data-styletype="dangerous">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    @endforelse
                    <tr class="row-view">
                        <td id="producers-table-view-1" data-viewid="1" data-component="row-view" data-toggled="false" colspan="4">
                            <div class="producer-data">
                                Producer data
                            </div>
                        </td>
                    </tr>
            </table>

            @if ($producers->hasPages())
            <div class="table-pagination">
                <span>A mostrar {{ $producers->total() }} de {{ $producers->perPage() }} por página</span>

                @if ($producers->onFirstPage())
                    <button type="button" class="ml-auto" disabled>
                        <i class="fa fa-arrow-left"></i>
                    </button>
                @else
                    <a href="{{ $producers->previousPageUrl() . '&filter=' . request('filter') }}" class="ml-auto">
                        <button type="button">
                            <i class="fa fa-arrow-left"></i>
                        </button>
                    </a>
                @endif

                @for ($page = 1; $page <= $producers->lastPage(); $page++)
                    @if ($page == $producers->currentPage())
                        <button type="button" disabled>{{ $page }}</button>
                    @else
                        <a href="{{ $producers->url($page) . '&filter=' . request('filter') }}">
                            <button type="button">{{ $page }}</button>
                        </a>
                    @endif
                @endfor

                @if ($producers->hasMorePages())
                    <a href="{{ $producers->nextPageUrl() . '&filter=' . request('filter') }}">
                        <button type="button">
                            <i class="fa fa-arrow-right"></i>
                        </button>
                    </a>
                @else
                    <button type="button" disabled>
                        <i class="fa fa-arrow-right"></i>
                    </button>
                @endif
            </div>
        @endif
        </section>
    </section>
</main>
@endsection
