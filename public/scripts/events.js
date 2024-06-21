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

        _element.insertAdjacentHTML('afterbegin', localeStrings[key]);
    });
};

export function QueueEvents () {
    SetSideBarEvent();
    SetPlanTogglerEvent();
    SetLinkEventListeners();
    SetFaqRowAccordionEvent();
};

function SetLinkEventListeners () {
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
