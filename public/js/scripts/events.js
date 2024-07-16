import { getMenuLink } from "./getters.js";
import locale from "./locale.js";
import utils from "./utils.js";

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
    const viewName = document.getElementById("menu-view").dataset.view;

    SetAsideMenuEvent();
    SetGotoLinkEvent();
    SetTableLoadRowViewEvent();
    SetToggleFormEvent();
    RunCrumbTrail(viewName);
};

export function RemoveEvents$Admin () {
    RemoveAsideMenuEvent();
    RemoveGotoLinkEvent();
    RemoveTableLoadRowViewEvent();
    RemoveMenuSwitchEvent();
    RemoveToggleFormEvent();
};

function RunCrumbTrail(menu, targetId=undefined) {
    const crumbTrail = utils.___GetCrumbTrail(getMenuLink(menu), targetId);
    
    document.getElementById('breadcrumbs').innerHTML = crumbTrail
        .map(({ id, name: nm, link, target: tgt=undefined }, idx) => { return `
            <span id="${id}" data-componenttype="crumblink"${(idx === (crumbTrail.length - 1)) ? ' class="index"' : ` data-event="goto-link" data-goto="${link}${(tgt) ? `:${tgt}` : ''}"`}>
                ${nm}
            </span>`
        })
        .join('<i class="arrow fa fa-angle-right"></i>')
    ;
}

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

function gotoLink ({ target }) {
    const [link, targetId=undefined] = (target.dataset?.goto ?? '/').split(':');

    const trail = utils.___GetCrumbTrail(link, targetId);

    const { id } = trail[trail.length - 1];

    document.getElementById(`side-menu-item:${id}`).click();
};

function loadRowView ({ target }) {
    const rowId = target.dataset.id;

    const tableView = document.querySelector(`td[data-viewid="${rowId}"]`);

    tableView.dataset.toggled = (tableView.dataset.toggled) === 'false';

    Array.from(document.querySelectorAll(`td[data-component="row-view"]`))
        .filter(viewCell => viewCell.dataset.viewid !== rowId)
        .forEach(viewCell => {
            console.log(viewCell);
            viewCell.dataset.toggled = 'false';
        });
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