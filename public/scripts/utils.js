function ___InitializeUtils () {
    const { disableLogs } = ___GetSiteConfigs();

    if (!disableLogs) console.log('---------------=====:: Preparing Utils');
};

function ___GetConstants () {
    return {
        ...constants
    }
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
    fmt_instagram_url: '#',
    fmt_facebook_url: '#',
    fmt_twitterx_url: '#',
    plan_1_monthly_price: '5.999,99',
    plan_1_yearly_price: '50.999,99',
    plan_2_monthly_price: '10.000,00',
    plan_2_yearly_price: '90.000,00'
};

const utils = {
    ___InitializeUtils,
    ___GetConstants,
    ___GetSiteConfigs
};

export default utils;