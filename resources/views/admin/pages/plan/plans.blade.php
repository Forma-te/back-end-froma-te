@extends('admin.templates.template-admin')

@section('contect')
<main id="menu-view" data-page="admin" data-view="plans">
    <section id="plans-menu" class="menu-container" data-active="true">
        <section id="plan-creation" class="menu-area gap-y-2">
            <button id="plan:create-plan" data-event="toggle-form" data-targetid="create-plan-form" type="button"
                class="fmt-button" data-styletype="primary" data-theme="light">
            </button>

            <form id="create-plan-form" action="{{ route('plans.store') }}" method="POST" class="section-form"
            data-isform="true" data-toggled="false" data-action="create" data-entity="plans" data-event="api">
            @csrf
            <h3>Cadastrar plano</h3>

            <label for="new-plan-name" class="w-full">
                <span>Nome</span>
                <input type="text" id="new-plan-name" class="w-full" name="name" value="{{ old('name') }}" placeholder="Nome do plano" />
            </label>

            <label for="new-plan-description" class="w-full">
                <span>Descrição</span>
                <textarea id="new-plan-description" class="w-full" name="description" placeholder="Descrição">{{ old('description') }}</textarea>
            </label>

            <div class="flex flex-row justify-start items-center gap-x-2">
                <label for="new-plan-price">
                    <span>Preço</span>
                    <input type="text" id="new-plan-price" name="price" value="{{ old('price') }}" min="0" placeholder="Preço" />
                </label>

                <label for="new-plan-qty">
                    <span>Quantidade</span>
                    <input type="text" id="new-plan-qty" name="quantity" value="{{ old('quantity') }}" min="1" placeholder="Quantidade" />
                </label>
            </div>

            <div class="publish-row">
                <input type="checkbox" id="new-plan-publish" name="published" {{ old('published') ? 'checked' : '' }}>
                <label for="new-plan-publish">
                    Publicar?
                </label>
            </div>

            <button id="plan:create-plan-submit" type="submit" class="fmt-button" data-styletype="primary" data-theme="light">
                Criar Plano
            </button>
        </form>
        </section>

        <h3>Planos</h3>

        <section id="plan-list" class="menu-area">
            <div class="table-search w-full">
                <i class="fa fa-search"></i>
                <input id="search-plans-table" name="search-key" type="text" />
            </div>

            <table id="plans-table" class="fmt-table" data-styletype="primary" data-theme="light"
                data-hasview="true">
                <thead>
                    <tr>
                        <th id="name">Nome</th>
                        <th id="price">Preço</th>
                        <th id="actions">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($plans->items() as $plan)
                    <tr id="plans-table-row-1" data-tableid="plans-table" data-id="1">
                        <td data-tableid="plans-table" data-id="1" class="name-col">{{ $plan->name }}</td>
                        <td data-tableid="plans-table" data-id="1" class="price-col">{{ number_format($plan->price, 2, ',', '.') }} AOA</td>
                        <td class="actions-col">
                            <button type="button" title="Aceitar pedido" class="fmt-button-circle" data-styletype="primary">
                                <i class="fa fa-save"></i>
                            </button>

                            <button type="button" title="Rejeitar pedido" class="fmt-button-circle" data-styletype="dangerous">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty

                    @endforelse
                </tbody>
            </table>

            <div class="table-pagination w-full">
                <span>A mostrar {{ $plans->count() }} de {{ $plans->total() }}</span>

                @if ($plans->onFirstPage())
                    <button type="button" class="ml-auto" disabled>
                        <i class="fa fa-arrow-left"></i>
                    </button>
                @else
                    <a href="{{ $plans->previousPageUrl() }}" class="ml-auto">
                        <button type="button">
                            <i class="fa fa-arrow-left"></i>
                        </button>
                    </a>
                @endif



                @if ($plans->hasMorePages())
                    <a href="{{ $plans->nextPageUrl() }}">
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
        </div>
        </section>
    </section>
</main>
@endsection
