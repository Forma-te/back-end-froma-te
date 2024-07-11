import requests from "./requests.js";

const {
    UsersAPI
} = requests;

export function getLinkMenu (link) {
    switch (link) {
        case '/': return 'main';
        case '/plans': return 'plans';
        case '/signatures': return 'signatures';
        case '/producers': return 'producers';
        case '/members': return 'members';
        case '/platform': return 'platform';
    
        default: return 'main';
    };
};

export function getMenuForms (menu) {
    switch (menu) {
        case 'main': return``;

        case 'plans': return {
            createPlanForm:`
            <form id="create-plan-form" class="section-form" data-isform="true" data-toggled="false" data-action="create" data-entity="plans" data-event="api">
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
                </button>
            </form>
            `
        };

        case 'signatures': return``;

        case 'producers': return``;

        case 'members': return`<form id="create-member-form" class="section-form" data-toggled="false">
        </form>`;

        case 'platform': return``;
    
        default: return``;
    };
};

export function getMenuLink (menu) {
    switch (menu) {
        case 'main': return '/';
        case 'plans': return '/plans';
        case 'signatures': return '/signatures';
        case 'producers': return '/producers';
        case 'members': return '/members';
        case 'platform': return '/platform';
    
        default: return '/';
    };
};

export async function getMembersTableConfig () {
    const actionsElement_STRING = `
        <button type="button" title="Eliminar membros" data-id="f432teh+" data-action="delete" data-entity="members" data-event="api" class="fmt-button-circle" data-styletype="dangerous">
            <i class="fa fa-trash"></i>
        </button>
    `;

    const headers = [
        { id: 'name', value: 'Nome' },
        { id: 'email', value: 'E-mail' },
        { id: 'actions', value: 'Ações' },
    ];

    const rows = [
        [
            { id: 'name', value: 'Some sample name' },
            { id: 'email', value: 'some.example@formate.com' },
            { id: 'actions', value: actionsElement_STRING },
        ],
        [
            { id: 'name', value: 'Another sample name' },
            { id: 'email', value: 'another.example@formate.com' },
            { id: 'actions', value: actionsElement_STRING },
        ],
    ];

    // new UsersAPI().GetMembers(({ data=null, error=null }) => {
    //     return {
    //         headers,
    //         rows
    //     };
    // });

    return {
        headers,
        rows
    };
};

export async function getProducersTableConfig () {
    const actionsElement_STRING = `
        <button type="button" title="Eliminar Instrutor" data-id="gfagagfhrt+" data-action="delete" data-entity="producer" data-event="api" class="fmt-button-circle" data-styletype="dangerous">
            <i class="fa fa-trash"></i>
        </button>
    `;
    
    const headers = [
        { id: 'name', value: 'Instrutor Nome' },
        { id: 'cursos', value: 'Cursos' },
        { id: 'students', value: 'Total Estudantes' },
        { id: 'actions', value: 'Ação' },
    ];

    const rows = [
        [
            { id: 'name', value: 'Some sample name' },
            { id: 'cursos', value: 3 },
            { id: 'students', value: 102 },
            { id: 'actions', value: actionsElement_STRING },
        ],
        [
            { id: 'name', value: 'Another sample name' },
            { id: 'cursos', value: 3 },
            { id: 'students', value: 102 },
            { id: 'actions', value: actionsElement_STRING },
        ],
    ];

    // new UsersAPI().GetProducers(({ data=null, error=null }) => {
    //     return {
    //         headers,
    //         rows
    //     };
    // });

    return {
        headers,
        rows
    };
};

export async function getProducerRequestsTableConfig () {
    const actionsElement_STRING = `
        <button type="button" title="Aceitar pedido" data-id="gveniwmq0+" data-action="accept" data-entity="producer" data-event="api" class="fmt-button-circle" data-styletype="primary">
            <i class="fa fa-thumbs-up"></i>
        </button>

        <button type="button" title="Rejeitar pedido" data-id="3243215fgf+" data-action="deny" data-entity="producer" data-event="api" class="fmt-button-circle" data-styletype="dangerous">
            <i class="fa fa-thumbs-down"></i>
        </button>
    `;

    const headers = [
        { id: 'name', value: 'Instrutor Nome' },
        { id: 'request-date', value: 'Data de pedido' },
        { id: 'type', value: 'Tipo' },
        { id: 'request-email', value: 'E-mail' },
        { id: 'actions', value: 'Ações' },
    ];

    const rows = [
        [
            { id: 'name', value: 'Some sample name' },
            { id: 'request-date', value: new Date().toLocaleDateString() },
            { id: 'type', value: 'Instrutor' },
            { id: 'request-email', value: 'some.example@formate.com' },
            { id: 'actions', value: actionsElement_STRING },
        ],
        [
            { id: 'name', value: 'Another sample name' },
            { id: 'request-date', value: new Date().toLocaleDateString() },
            { id: 'type', value: 'Instrutor' },
            { id: 'request-email', value: 'another.example@formate.com' },
            { id: 'actions', value: actionsElement_STRING },
        ],
    ];

    // new UsersAPI().GetProducers(({ data=null, error=null }) => {
    //     return {
    //         headers,
    //         rows
    //     };
    // });

    return {
        headers,
        rows
    };
};

export async function getSignaturesTableConfig () {
    const headers = [
        { id: 'email', value: 'E-mail instrutor' },
        { id: 'transaction', value: 'Transação Nº' },
        { id: 'months', value: 'Mensalidade' },
        { id: 'date', value: 'Data' },
    ];

    const rows = [
        [
            { id: 'email', value: 'example@gmail.com' },
            { id: 'transaction', value: 354632123 },
            { id: 'months', value: 3 },
            { id: 'date', value: new Date().toLocaleString() },
        ],
        [
            { id: 'email', value: 'another@gmail.com' },
            { id: 'transaction', value: 543276843 },
            { id: 'months', value: 1 },
            { id: 'date', value: new Date().toLocaleString() },
        ]
    ];

    return {
        headers,
        rows
    };
};

export async function getSignatureRequestsTableConfig () {
    const stateSpanElement_STRING = (state) => {
        switch (state) {
            case 'approve': return `<span class="fmt-tag" data-styletype="approved">Aprovado</span>`;
            case 'denied': return `<span class="fmt-tag" data-styletype="dangerous">Rejeitado</span>`;
            case 'waiting': return `<span class="fmt-tag" data-styletype="warning">Em Espera</span>`;
        
            default: return '';
        }
    };

    const headers = [
        { id: 'email', value: 'E-mail instrutor' },
        { id: 'months', value: 'Mensalidade' },
        { id: 'initDate', value: 'Data Início' },
        { id: 'renwDate', value: 'Data Renovação' },
        { id: 'status', value: 'Estado' },
    ];

    const rows = [
        [
            { id: 'email', value: 'example1@gmail.com' },
            { id: 'months', value: 3 },
            { id: 'initDate', value: new Date().toLocaleString() },
            { id: 'renwDate', value: new Date().toLocaleString() },
            { id: 'status', value: stateSpanElement_STRING('approve') },
        ],
        [
            { id: 'email', value: 'example2@gmail.com' },
            { id: 'months', value: 6 },
            { id: 'initDate', value: new Date().toLocaleString() },
            { id: 'renwDate', value: new Date().toLocaleString() },
            { id: 'status', value: stateSpanElement_STRING('waiting') },
        ],
        [
            { id: 'email', value: 'example2@gmail.com' },
            { id: 'months', value: 6 },
            { id: 'initDate', value: new Date().toLocaleString() },
            { id: 'renwDate', value: new Date().toLocaleString() },
            { id: 'status', value: stateSpanElement_STRING('denied') },
        ],
    ];

    return {
        headers,
        rows
    };
};