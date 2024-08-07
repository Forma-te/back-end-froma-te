import utils from "./scripts/utils.js";
import requests from "./scripts/requests.js";
import locale from "./scripts/locale.js";
import {
    InjectData$Admin,
    QueueEvents$Admin
} from "./scripts/events.js";
import components from "./scripts/components.js";
import { Render$FooterLinks } from "./scripts/renderers.js";


function ___InitializePage () {
    utils.___InitializeUtils();
    requests.___InitializeRequests();
    components.___InitializeComponents();

    const { disableLogs } = utils.___GetSiteConfigs();

    if (!disableLogs) console.log('---------------=====:: Initialized page main scripts');

    window.onload = (e) => {
        if (!disableLogs) console.log('---------------:: In # Window.Onload');

        const {
            DEFAULT_LOCALE
        } = utils.___GetConstants();

        const LOCALE_STRINGS = locale.___GetLocaleStrings(DEFAULT_LOCALE);

        if (!disableLogs) console.log('---------------=====:: Rendering Elements');
        Render$FooterLinks(LOCALE_STRINGS, DEFAULT_LOCALE);

        if (!disableLogs) console.log('---------------=====:: Queuing Events');
        QueueEvents$Admin();

        if (!disableLogs) console.log('---------------=====:: Injecting Data & Strings');
        InjectData$Admin({ localeStrings: LOCALE_STRINGS });

        if (!disableLogs) console.log('---------------:: Out # Window.Onload');
    };
};

___InitializePage();
