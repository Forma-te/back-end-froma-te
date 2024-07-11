import { Table } from "./components.js";
import { getMenuLink, getProducerRequestsTableConfig, getProducersTableConfig, getSignatureRequestsTableConfig, getSignaturesTableConfig } from "./getters.js";
import locale from "./locale.js";
import { Render$MenuContent, Render$ProducerTableDataView, Render$SignatureTableDataView } from "./renderers.js";
import utils from "./utils.js";
import requests from "./requests.js";

const {
    PlansAPI,
    SignaturesAPI,
    UsersAPI
} = requests;

export function Inject$HREFURLs () {
    const {
        fmt_instagram_url,
        fmt_facebook_url,
        fmt_twitterx_url,
    } = utils.___GetConstants();

    document.getElementById('goto:fmt-instagram').href = fmt_instagram_url;
    document.getElementById('goto:fmt-facebook').href = fmt_facebook_url;
    document.getElementById('goto:fmt-twitterx').href = fmt_twitterx_url;
};

export function Inject$LocaleStrings (localeStrings) {
    Object.keys(localeStrings).forEach(key => {
        const _element = document.getElementById(key);

        if (!_element) return;

        _element.innerHTML = localeStrings[key];
    });
};

export function InjectData$Index ({ localeStrings }) {
    Inject$HREFURLs();
    Inject$LocaleStrings(localeStrings);
};

export function QueueEvents$Index () {
    SetSideBarEvent();
    SetPlanTogglerEvent();
    SetLinkEvent();
    SetFaqRowAccordionEvent();
};

export function InjectData$Admin ({ localeStrings }) {
    Inject$HREFURLs();
    Inject$LocaleStrings(localeStrings);
};

export function QueueEvents$Admin ({ setDefault=true }={}) {
    SetAsideMenuEvent();
    SetAPIRequestEvent();
    SetMenuLinkEvent({ setDefault });
    SetGotoLinkEvent();
    SetTableLoadRowViewEvent();
    SetTableSwitchEvent();
    SetToggleFormEvent();
};

export function RemoveEvents$Admin () {
    RemoveAsideMenuEvent();
    RemoveAPIRequestEvent();
    RemoveMenuLinkEvent();
    RemoveGotoLinkEvent();
    RemoveTableLoadRowViewEvent();
    RemoveTableSwitchEvent();
    RemoveToggleFormEvent();
};

export function ViewLoader$Admin (defaultView=utils.___GetConstants().DEFAULT_VIEW) {
    LoadViewMenu(defaultView, defaultView);
};

async function LoadViewMenu (menu, targetId=undefined) {
    RemoveEvents$Admin();
    
    await Render$MenuContent(
        locale.___GetLocaleStrings(utils.___GetConstants().DEFAULT_LOCALE), 
        utils.___GetConstants().DEFAULT_LOCALE,
        menu
    );

    const crumbTrail = utils.___GetCrumbTrail(getMenuLink(menu), targetId);
    
    document.getElementById('breadcrumbs').innerHTML = crumbTrail
        .map(({ id, name: nm, link, target: tgt=undefined }, idx) => { return `
            <span id="${id}" data-componenttype="crumblink"${(idx === (crumbTrail.length - 1)) ? ' class="index"' : ` data-event="goto-link" data-goto="${link}${(tgt) ? `:${tgt}` : ''}"`}>
                ${nm}
            </span>`
        })
        .join('<i class="arrow fa fa-angle-right"></i>')
    ;

    QueueEvents$Admin({ setDefault: false });

    Inject$LocaleStrings(locale.___GetLocaleStrings(utils.___GetConstants().DEFAULT_LOCALE));
};

function SetAPIRequestEvent () {
    Array.from(document.querySelectorAll("*[data-event='api']")).forEach(element => {
        element.addEventListener('click', APIRequest);
    });
};

function RemoveAPIRequestEvent () {
    Array.from(document.querySelectorAll("*[data-event='api']")).forEach(element => {
        element.removeEventListener('click', APIRequest);
    });
};

function SetAsideMenuEvent() {
    document.getElementById('side-menu-close-btn').addEventListener('click', toggleAsideMenu);
};

function RemoveAsideMenuEvent() {
    document.getElementById('side-menu-close-btn').removeEventListener('click', toggleAsideMenu);
};

function SetGotoLinkEvent () {
    Array.from(document.querySelectorAll("*[data-event='goto-link']")).forEach(element => {
        element.addEventListener('click', gotoLink);
    });
};

function RemoveGotoLinkEvent () {
    Array.from(document.querySelectorAll("*[data-event='goto-link']")).forEach(element => {
        element.removeEventListener('click', gotoLink);
    });
};

function SetLinkEvent () {
    Array.from(document.querySelectorAll("*[data-event='link']")).forEach(element => {
        element.addEventListener('click', ({ target }) => window.open(target.dataset?.gotourl ?? '#', '_blank'));
    });
};

function SetFaqRowAccordionEvent () {
    Array.from(document.getElementsByClassName('fmt-faq-row')).forEach(element => {
        element.addEventListener('click', ({ target }) => target.dataset.toggled = (target.dataset.toggled === 'true') ? 'false' : 'true');
    });
};

function SetPlanTogglerEvent () {
    document.getElementById('monthly-pricing-toggler').addEventListener('click', togglePlanPrices('monthly'));
    document.getElementById('yearly-pricing-toggler').addEventListener('click', togglePlanPrices('yearly'));
};

function SetSideBarEvent () {
    Array.from(document.querySelectorAll('a[data-componenttype="sidebar-link"]')).forEach(anchor => {
        anchor.addEventListener('click', toggleSideBar(false));
    });

    document.getElementById('side-bar-open-btn').addEventListener('click', toggleSideBar(true));
    document.getElementById('side-bar-close-btn').addEventListener('click', toggleSideBar(false));
};

function SetMenuLinkEvent ({ setDefault=false }={}) {
    if (setDefault) Array.from(document.querySelectorAll('button[data-componenttype="sidemenu-link"]')).forEach(button => {
        const isCurrentActiveLink = button.id.split(':')[1] === utils.___GetConstants().DEFAULT_VIEW;

        button.dataset.active = `${isCurrentActiveLink}`;
    });

    Array.from(document.querySelectorAll('button[data-componenttype="sidemenu-link"]')).forEach(button => {
        button.addEventListener('click', EVENT_CLUSTER_menuLink);
    });
};

function RemoveMenuLinkEvent () {
    Array.from(document.querySelectorAll('button[data-componenttype="sidemenu-link"]')).forEach(button => {
        button.removeEventListener('click', EVENT_CLUSTER_menuLink);
    });
};


function SetTableLoadRowViewEvent () {
    Array.from(document.querySelectorAll('tr[data-event="load-view"]')).forEach(row => {
        row.addEventListener('click', loadRowView);
    });
};

function RemoveTableLoadRowViewEvent () {
    Array.from(document.querySelectorAll('tr[data-event="load-view"]')).forEach(row => {
        row.removeEventListener('click', loadRowView);
    });
};
function SetTableSwitchEvent () {
    Array.from(document.querySelectorAll('button[data-event="switch-tables"]')).forEach(button => {
        button.addEventListener('click', switchTable);
    });
};

function RemoveTableSwitchEvent () {
    Array.from(document.querySelectorAll('button[data-event="switch-tables"]')).forEach(button => {
        button.removeEventListener('click', switchTable);
    });
};

function SetToggleFormEvent() {
    Array.from(document.querySelectorAll('button[data-event="toggle-form"]')).forEach(button => {
        button.addEventListener('click', toggleForm);
    });
};

function RemoveToggleFormEvent() {
    Array.from(document.querySelectorAll('button[data-event="toggle-form"]')).forEach(button => {
        button.removeEventListener('click', toggleForm);
    });
};

async function APIRequest ({ target }) {
    let id, payload, isForm;

    const action = target.dataset.action;
    const entity = target.dataset.entity;

    switch (entity) {
        case 'members':
            id=target.dataset.id ?? null;

            switch (action) {
                case 'delete':
                    new UsersAPI().DeleteMember(id, ({ data=null, error=null }) => {

                    });
                break;
            
                default:break;
            }
        break;

        case 'plans':
            isForm = target.dataset?.isform ? (target.dataset.isform === 'true') : false;

            if (!isForm) (id=target.dataset.id ?? null);

            else {
                console.log('Get form data')
            };

            switch (action) {
                case 'create':
                    new PlansAPI().CreatePlan((isForm) ? payload : id, ({ data=null, error=null }) => {

                    });
                break;
            
                default:break;
            }
        break;

        case 'producer':
            id=target.dataset.id ?? null;

            switch (action) {
                case 'accept':
                    new UsersAPI().AcceptProducerRequest(id, ({ data=null, error=null }) => {

                    });
                break;

                case 'delete':
                    new UsersAPI().DeleteProducer(id, ({ data=null, error=null }) => {

                    });
                break;

                case 'deny':
                    new UsersAPI().DenyProducerRequest(id, ({ data=null, error=null }) => {

                    });
                break;
            
                default:break;
            }
        break;

        case 'signature':
            switch (action) {
                case 'confirm-payment':
                    const expiryDateElement = document.getElementById('expiry-date');

                    const expiryDate = expiryDateElement.value;

                    const signatureId = expiryDateElement.dataset.signatureid;

                    new SignaturesAPI().ConfirmPayment({ id: signatureId, expiryDate }, ({ data=null, error=null }) => {
                        if (error) ScheduleNotification('payment-confirmation-error');

                        else {
                            ScheduleNotification('successful-payment-confirmation');
                        }
                    });
                break;
            
                default: break;
            }
        break;
    
        default:
        break;
    }
};

function gotoLink ({ target }) {
    const [link, targetId=undefined] = (target.dataset?.goto ?? '/').split(':');

    const trail = utils.___GetCrumbTrail(link, targetId);

    const { id } = trail[trail.length - 1];

    document.getElementById(`side-menu-item:${id}`).click();
};

async function loadRowView ({ target }) {
    const tableId = target.dataset.tableid;
    const rowId = target.dataset.id;
    
    if ([tableId, rowId].some(value => [undefined, null].includes(value))) return;

    RemoveAPIRequestEvent();

    const closeView = document.getElementById(`${tableId}-view-${rowId}`).dataset.toggled === 'true';

    Array.from(document.querySelectorAll(`td[data-viewname="${tableId}-view"][data-component="row-view"]`)).forEach(viewCell => {
        viewCell.dataset.toggled = 'false';
        viewCell.innerHTML='';
    });

    if (closeView) return;

    switch (tableId) {
        case 'producers-table':
            await Render$ProducerTableDataView(rowId, tableId);
        break;

        case 'signatures-table':
            await Render$SignatureTableDataView(rowId, tableId);
        break;
    
        default: break;
    }

    SetAPIRequestEvent();
};

function renderMenuLinkView ({ target }) {
    const menu = target.dataset.rendermenu;
    const targetId = target.dataset?.targetid ?? undefined;

    LoadViewMenu(menu, targetId ?? menu);
};

async function switchTable ({ target }) {
    if (target.dataset.active === 'true') return;

    RemoveTableLoadRowViewEvent();
    RemoveAPIRequestEvent();

    const eventId = target.dataset.eventid;
    const tableName = target.dataset.currenttable;

    Array.from(document.querySelectorAll(`button[data-event="switch-tables"][data-eventid="${eventId}"]`))
        .forEach(button => button.dataset.active = false);

    target.dataset.active = true;

    let headers, rows, _Table;

    switch (tableName) {
        case 'producers-table':
            ({ headers, rows } = await getProducerRequestsTableConfig());

            _Table = Table({ id: 'producers-requests-table', headers, rows });
        break;
            
        case 'producers-requests-table':
            ({ headers, rows } = await getProducersTableConfig());

            _Table = Table({ id: 'producers-table', headers, rows, withView: true });
        break;

        case 'signatures-table':
            ({ headers, rows } = await getSignatureRequestsTableConfig());

            _Table = Table({ id: 'signature-requests-table', headers, rows });
        break;

        case 'signature-requests-table':
            ({ headers, rows } = await getSignaturesTableConfig());   

            _Table = Table({ id: 'signatures-table', headers, rows, withView: true });
        break;
    
        default: break;
    };

    const currentTableElement = document.getElementById(tableName);

    currentTableElement.insertAdjacentHTML('afterend', _Table);

    currentTableElement.remove();

    SetTableLoadRowViewEvent();
    SetAPIRequestEvent();
};

function toggleForm ({ target }) {
    const formId = target.dataset.targetid;

    const formElement = document.getElementById(formId);

    if (!formElement) return;

    const isToggled = formElement.dataset.toggled === 'true';

    target.innerText = (!isToggled) ? 'Cancelar' : locale.___GetLocaleString(utils.___GetConstants().DEFAULT_LOCALE, target.id);
    target.dataset.styletype = (!isToggled) ? 'secondary' : 'primary';

    if (isToggled) formElement.reset();

    formElement.dataset.toggled = `${!isToggled}`;
};

function togglePlanPrices (pricingType) {
    return ({ target }) => {
        const plan1Text = document.getElementById('plan-1-price');
        const plan2Text = document.getElementById('plan-2-price');

        const {
            plan_1_monthly_price, plan_1_yearly_price,
            plan_2_monthly_price, plan_2_yearly_price
        } = utils.___GetConstants();

        switch (pricingType) {
            case 'monthly':
                target.dataset.toggled = 'true';

                document.getElementById('yearly-pricing-toggler').dataset.toggled = 'false';

                plan1Text.innerText = plan_1_monthly_price;
                plan2Text.innerText = plan_2_monthly_price;
            break;

            case 'yearly':
                target.dataset.toggled = 'true';

                document.getElementById('monthly-pricing-toggler').dataset.toggled = 'false';

                plan1Text.innerText = plan_1_yearly_price;
                plan2Text.innerText = plan_2_yearly_price;
            break;
        
            default: break;
        }
    };
};

function toggleSideBar (state) {
    return ({ target }) => {
        const sideBarElement = document.getElementById('side-bar');
        const overlayElement = document.querySelector('.overlay[data-parent="body"]');

        overlayElement.dataset.toggled = state;
        sideBarElement.dataset.toggled = state;
    };
};

function EVENT_CLUSTER_menuLink (e) {
    const sideMenuElement = document.getElementById('side-menu');

    const state = sideMenuElement.dataset.toggled === 'true';

    if (state) toggleAsideMenu({ target: document.getElementById('side-menu-close-btn') });
    
    toggleMenuLinkStyle(e);
    renderMenuLinkView(e);
};

function toggleMenuLinkStyle ({ target }) {
    Array.from(document.querySelectorAll('button[data-componenttype="sidemenu-link"]')).forEach(button => {
        button.dataset.active = 'false';
    });

    target.dataset.active = 'true';
};

function toggleSideMenu (state) {
    return ({ target }) => {
        const sideMenuElement = document.getElementById('side-menu');
        const overlayElement = document.querySelector('.overlay[data-parent="body"]');

        overlayElement.dataset.toggled = state;
        sideMenuElement.dataset.toggled = state;
    };
};

function toggleAsideMenu ({ target }) {
    const sideMenuElement = document.getElementById('side-menu');

    const state = sideMenuElement.dataset.toggled === 'true';

    target.innerHTML = '';
    target.innerHTML = !state ? '<i class="fa fa-angle-left"></i>' : '<i class="fa fa-angle-right"></i>';

    sideMenuElement.dataset.toggled = !state ? 'true' : 'false';
};

export function ScheduleNotification (id, data=null) {
    const notificationElement = document.getElementById('notification');

    if (!notificationElement) return;

    switch (id) {
        case 'get-producer-error':
        case 'get-signature-error':
        case 'payment-confirmation-error': 
            notificationElement.dataset.styletype="dangerous";
        break;

        case 'successful-payment-confirmation': 
            notificationElement.dataset.styletype="approved"; 
        break;
    
        default: break;
    };

    notificationElement.innerHTML=locale.___GetLocaleString(utils.___GetConstants().DEFAULT_LOCALE, id);

    notificationElement.dataset.active="true";

    setTimeout(() => {
        notificationElement.innerHTML="";

        notificationElement.dataset.styletype="primary";
        notificationElement.dataset.active="false";
    }, 4000);
};