import { getMenuLink } from "./getters.js";

function ___InitializeUtils () {
    const { disableLogs } = ___GetSiteConfigs();

    if (!disableLogs) console.log('---------------=====:: Preparing Utils');
};

function ___GetConstants () {
    return {
        ...constants
    }
};

function ___GetCrumbTrail (link=undefined, targetId=undefined) {
    const BreadCrumbTrail = new Map();

    BreadCrumbTrail.set('/', [
        { id: 'main', link: getMenuLink('main'), name: 'Página Inicial', target: 'main' }
    ]);
    
    BreadCrumbTrail.set('/plans', [
        { id: 'plans', link: getMenuLink('plans'), name: 'Planos', target: 'plans' }
    ]);

    BreadCrumbTrail.set('/signatures', [
        { id: 'signatures', link: getMenuLink('signatures'), name: 'Assinaturas', target: 'signatures' }
    ]);

    BreadCrumbTrail.set('/producers', [
        { id: 'producers', link: getMenuLink('producers'), name: 'Produtores', target: 'producers' }
    ]);

    BreadCrumbTrail.set('/members', [
        { id: 'members', link: getMenuLink('members'), name: 'Membros', target: 'members' }
    ]);

    BreadCrumbTrail.set('/platform', [
        { id: 'platform', link: getMenuLink('platform'), name: 'Plataforma', target: 'platform' }
    ]);

    if (!link || !BreadCrumbTrail.get(link)) return BreadCrumbTrail;

    if (targetId) {
        const index = BreadCrumbTrail.get(link).findIndex(({ target }) => target === targetId);

        return BreadCrumbTrail.get(link)
            .map((trail, idx) => { return (idx <= index) ? trail : null })
            .filter(trail => trail !== null)
        ;
    }

    return BreadCrumbTrail.get(link);
};

function ___GetSiteConfigs () {
    return {
        ...configs
    }
};

const configs = {
    disableLogs: true
};

const constants = {
    DEFAULT_LOCALE:'pt',
    DEFAULT_PRICING: 'yearly',
    DEFAULT_VIEW: 'main',
    fmt_instagram_url: '#',
    fmt_facebook_url: '#',
    fmt_twitterx_url: '#',
    plan_1_monthly_price: '5.999,99',
    plan_1_yearly_price: '50.999,99',
    plan_2_monthly_price: '10.000,00',
    plan_2_yearly_price: '90.000,00',
};

const utils = {
    ___InitializeUtils,
    ___GetConstants,
    ___GetCrumbTrail,
    ___GetSiteConfigs
};

export default utils;