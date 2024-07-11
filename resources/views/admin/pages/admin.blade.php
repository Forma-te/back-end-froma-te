<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FORMA-TE | Admin</title>
    <link rel="icon" href="./favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="{{ '/assets/css/global_.css' }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body data-page="admin">
    <div class="overlay" data-parent="body" data-toggled="false"></div>

    <div id="notification" data-active="false" data-styletype="primary" data-theme="light"></div>

    <aside id="side-menu" data-toggled="false">
        <button id="side-menu-close-btn" type="button">
            <i class="fa fa-angle-right"></i>
        </button>

        <p id="logo" class="text-3xl">FORMA-TE</p>

        <hr class="my-3" />

        <p id="side-menu:title1" class="title"></p>

        <button id="side-menu-item:main" data-rendermenu="main" data-active="true" data-componenttype="sidemenu-link"></button>
        <button id="side-menu-item:plans" data-rendermenu="plans" data-active="false" data-componenttype="sidemenu-link"></button>
        <button id="side-menu-item:signatures" data-rendermenu="signatures-list" data-active="false" data-componenttype="sidemenu-link"></button>
        <button id="side-menu-item:producers" data-rendermenu="producers-list" data-active="false" data-componenttype="sidemenu-link"></button>
        <button id="side-menu-item:members" data-rendermenu="members" data-active="false" data-componenttype="sidemenu-link"></button>
        <button id="side-menu-item:platform" data-rendermenu="platform" data-active="false" data-componenttype="sidemenu-link"></button>

        <hr class="my-3" />

        <p class="w-full text-center opacity-50 mt-auto">
            <span id="side-menu:copyright-1"></span> <br />
            <span id="side-menu:copyright-2"></span>
        </p>
    </aside>

    <nav id="nav-bar">
        <button id="side-menu-open-btn" type="button">
            <i class="fa fa-bars"></i>
        </button>

        <p id="breadcrumbs">
        </p>
    </nav>

    <main id="menu-view" data-page="admin" data-view="main">
        <section id="main-menu" class="menu-container" data-active="true">
            <h3>Links rápidos</h3>

            <section id="quick-links" class="menu-area">
                <button type="button" data-event="goto-link" data-goto="/plans">
                    <i class="fa fa-link"></i>
                    <span id="quick-link:plans"></span>
                </button>

                <button type="button" data-event="goto-link" data-goto="/signatures">
                    <i class="fa fa-link"></i>
                    <span id="quick-link:signatures"></span>
                </button>

                <button type="button" data-event="goto-link" data-goto="/producers">
                    <i class="fa fa-link"></i>
                    <span id="quick-link:producers"></span>
                </button>

                <button type="button" data-event="goto-link" data-goto="/members">
                    <i class="fa fa-link"></i>
                    <span id="quick-link:members"></span>
                </button>

                <button type="button" data-event="goto-link" data-goto="/platform">
                    <i class="fa fa-link"></i>
                    <span id="quick-link:platform"></span>
                </button>
            </section>
        </section>

        <section id="plans-menu" class="menu-container" data-active="false">
            <section id="plan-creation" class="menu-area gap-y-2">
                <button id="plan:create-plan" data-event="toggle-form" data-targetid="create-plan-form" type="button" class="w-full fmt-button" data-styletype="primary" data-theme="light">
                </button>

                <form
                    id="create-plan-form"
                    class="section-form"
                    data-toggled="false"
                    action="{{ route('plans.create') }}" method="POST"
                >
                    <h3>Cadastrar plano</h3>

                    <label for="new-plan-name" class="w-full">
                        <span>Nome</span>

                        <input type="text" id="new-plan-name" class="w-full" name="name" placeholder="Nome do plano" />
                    </label>

                    <label for="new-plan-description" class="w-full">
                        <span>Descrição</span>

                        <textarea id="new-plan-description" class="w-full" name="description" placeholder="Descrição">
                        </textarea>
                    </label>

                    <div class="flex flex-row justify-start items-center gap-x-2">
                        <label for="new-plan-price">
                            <span>Preço</span>

                            <input type="number" id="new-plan-price" name="price" min="0" placeholder="Preço"/>
                        </label>

                        <label for="new-plan-qty">
                            <span>Quantidade</span>

                            <input type="number" id="new-plan-qty" name="quanity" min="1" placeholder="Quantidade" />
                        </label>
                    </div>

                    <div class="publish-row">
                        <input type="checkbox" id="new-plan-publish" name="publish?" />

                        <label for="new-plan-publish">
                            Publicar?
                        </label>
                    </div>

                    <button id="plan:create-plan-submit" type="button" class="w-full fmt-button" data-styletype="special" data-theme="light">
                        {{ $data->translation->plan_createPlanSubmit }}
                    </button>
                </form>
            </section>

            <h3>Planos</h3>

            <section id="plan-list" class="menu-area gap-y-2">
                @forelse ($plans as $plan)
                    <form
                        id="{{"{$plan->id}-form"}}" class="plan-form" data-styletype="primary" data-theme="light"
                        action="{{ route('plans.update', $plan->id) }}" method="POST"
                    >
                        <label class="name" for="{{"plan-{$plan->id}"}}">
                            <span>Nome</span>

                            <input type="text" name="name" id="{{"plan-{$plan->id}"}}" value="{{$plan->name}}" />
                        </label>

                        <label class="price" for="{{"plan-{$plan->id}-price"}}">
                            <span>Preço</span>

                            <input type="number" name="price" id="{{"plan-{$plan->id}-price"}}" value="{{$plan->price}}" min="0" />
                        </label>

                        <div class="actions">
                            <button
                                type="button"
                                title="{{"Salvar alterações do plano '{$plan->name}'"}}"
                                data-action="save-changes"
                                data-entity="plan"
                                data-event="api"
                                class="fmt-button-circle"
                                data-styletype="approved"
                            >
                                <i class="fa fa-save"></i>
                            </button>

                            <button
                                type="button"
                                title="{{"Eliminar plano '{$plan->name}'"}}"
                                data-action="delete"
                                data-entity="plan"
                                data-event="api"
                                class="fmt-button-circle"
                                data-styletype="dangerous"
                            >
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </form>
                @empty
                    <div class="w-full flex flex-row justify-center items-center">
                        Cria um plano
                    </div>
                @endforelse
            </section>
        </section>

        <section id="signatures-list-menu" class="menu-container" data-active="false">
            <h3>Gestão de assinaturas solicitadas</h3>

            <section id="signatures-list" class="menu-area">
                <div class="w-full flex flex-row justify-start items-center mb-3 gap-x-2">
                    <button type="button" id="signatures:signature-tab" class="tab" data-active="true" data-targetid="signature-requests-list-menu" data-event="switch-menu"></button>
                    <button type="button" id="signatures:requests-tab" class="tab" data-active="false" data-targetid="signature-list-menu" data-event="switch-menu"></button>
                </div>

                <form action="{{ route('signatures.getMany') }}" method="POST">
                    <div class="table-search">
                        <i class="fa fa-search"></i>
                        <input id="search-signature-table" name="search-key" type="text" />
                    </div>

                    <table id="signatures-table" class="fmt-table" data-styletype="primary" data-theme="light" data-hasview="true">
                        <thead>
                            <tr>
                                <th id="email">E-mail instrutor</th>
                                <th id="transaction">Transação Nº</th>
                                <th id="months">Mensalidade</th>
                                <th id="date">Data</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($signaturesPages as $signatureRow)
                                <tr id="{{"signatures-table-row-{$loop->index + 1}"}}" data-tableid="signatures-table" data-id="{{$loop->index + 1}}">
                                    @foreach ($signatureRow as $cell)
                                        <td class="{{"{$cell}-col"}}">{{$cell}}</th>
                                    @endforeach
                                </tr>

                                <tr class="row-view">
                                    <td id="{{"signatures-table-view-{$loop->index + 1}"}}" data-viewname="signatures-table-view" data-component="row-view" data-toggled="false" colspan="{{count($signatureRow)}}">
                                        {{@include('/partials/_signature-data.php')}}
                                    </td>
                                </tr>
                            @empty
                                <tr id="signatures-table-row-1" data-tableid="signatures-table" data-id="1">
                                    <td id="empty" colspan="4">
                                        Sem assinaturas
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="table-pagination">
                        <span>A mostrar {{count($signaturesPages)}}</span>

                        <button type="button" class="ml-auto">
                            <i class="fa fa-arrow-left"></i>
                        </button>

                        <button type="button">
                            <i class="fa fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </section>
        </section>

        <section id="signature-requests-list-menu" class="menu-container">
            <h3>Gestão de assinaturas solicitadas</h3>

            <section id="signature-requests-list" class="menu-area">
                <div class="w-full flex flex-row justify-start items-center mb-3 gap-x-2">
                    <button type="button" id="signatures:signature-tab" class="tab" data-active="false" data-targetid="signature-requests-list-menu" data-event="switch-menu"></button>
                    <button type="button" id="signatures:requests-tab" class="tab" data-active="true" data-targetid="signature-list-menu" data-event="switch-menu"></button>
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
                            @forelse ($signatureRequestsPages as $signatureRow)
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
                        <span>A mostrar {{count($signatureRequestsPages)}}</span>

                        <button type="button" class="ml-auto">
                            <i class="fa fa-arrow-left"></i>
                        </button>

                        <button type="button">
                            <i class="fa fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </section>
        </section>

        <section id="producers-list-menu" class="menu-container">
            <h3>Listagem</h3>

            <section id="producers-list" class="menu-area">
                <div class="w-full flex flex-row justify-start items-center mb-3 gap-x-2">
                    <button type="button" id="producers:producers-tab" class="tab" data-targetid="producers-list-menu" data-active="true" data-event="switch-menu"></button>
                    <button type="button" id="producers:requests-tab" class="tab" data-targetid="producers-requests-list-menu" data-active="false" data-event="switch-menu"></button>
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

                        <button type="button" class="ml-auto">
                            <i class="fa fa-arrow-left"></i>
                        </button>

                        <button type="button">
                            <i class="fa fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </section>
        </section>

        <section id="producers-requests-list-menu" class="menu-container">
            <h3>Listagem</h3>

            <section id="producers-requests-list" class="menu-area">
                <div class="w-full flex flex-row justify-start items-center mb-3 gap-x-2">
                    <button type="button" id="producers:producers-tab" class="tab" data-targetid="producers-list-menu" data-active="false" data-event="switch-menu"></button>
                    <button type="button" id="producers:requests-tab" class="tab" data-targetid="producers-requests-list-menu" data-active="true" data-event="switch-menu"></button>
                </div>

                <form action="{{ route('producers.requests.getMany') }}" method="POST">
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
                            @forelse ($producerRequestsPages as $producerRow)
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
                        <span>A mostrar {{count($producerRequestsPages)}}</span>

                        <button type="button" class="ml-auto">
                            <i class="fa fa-arrow-left"></i>
                        </button>

                        <button type="button">
                            <i class="fa fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </section>
        </section>

        <section id="members-menu" class="menu-container">
            <section id="member-registration" class="menu-area gap-y-2">
                <button id="member:create-member" data-event="toggle-form" data-targetid="create-member-form" type="button" class="w-full fmt-button" data-styletype="primary" data-theme="light">
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

                        <button type="button" class="ml-auto">
                            <i class="fa fa-arrow-left"></i>
                        </button>

                        <button type="button">
                            <i class="fa fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </section>
        </section>

        <section id="platform-menu" class="menu-container">
            <h3>Quem somos</h3>

            <section id="who-are-we" class="menu-area gap-y-2">
            </section>

            <h3>Benefícios</h3>

            <section id="benefits" class="menu-area gap-y-2">
            </section>

            <h3>Quem usa</h3>

            <section id="who-uses-it" class="menu-area gap-y-2">
            </section>

            <h3>Contactos</h3>

            <section id="contacts" class="menu-area gap-y-2">
            </section>

            <h3>Central de ajuda</h3>

            <section id="help-center" class="menu-area gap-y-2">
            </section>

            <h3>Funcionalidades</h3>

            <section id="functionalities" class="menu-area gap-y-2">
            </section>

            <h3>Termos de uso</h3>

            <section id="terms" class="menu-area gap-y-2">
            </section>

            <h3>Políticas de privacidade</h3>

            <section id="policy" class="menu-area gap-y-2">
            </section>

            <h3>Categoria</h3>

            <section id="categories" class="menu-area gap-y-2">
            </section>
        </section>
    </main>

    <footer data-componenttype="container"
        data-theme="dark">
        <section id="footer-links"></section>

        <section id="footer-social-media">
            <a id="goto:fmt-instagram" target="_blank" rel="noreferrer" class="fmt-social-link-button"
                data-styletype="primary" data-theme="dark">
                <img src="{{'/assets/img/png/ic_instagram.png'}}" alt="instagram's logo" />
            </a>

            <a id="goto:fmt-facebook" target="_blank" rel="noreferrer" class="fmt-social-link-button mx-2"
                data-styletype="primary" data-theme="dark">
                <img src="{{'/assets/img/png/ic_facebook.png'}}" alt="facebook's logo" />
            </a>

            <a id="goto:fmt-twitterx" target="_blank" rel="noreferrer" class="fmt-social-link-button"
                data-styletype="primary" data-theme="dark">
                <img src="{{'/assets/img/png/ic_x_twitter.png'}}" alt="twitter-x's logo" />
            </a>
        </section>

        <p id="footer-meta" class="w-full text-center opacity-50">
            <span id="footer:copyright-1"></span> <br />
            <span id="footer:copyright-2"></span>
        </p>
    </footer>

    <script  type="module" src="{{ asset('js/main-admin.js') }}"></script>
</body>

</html>
