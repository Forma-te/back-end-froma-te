import utils from "./utils.js";
import requests from "./requests.js";
import locale from "./locale.js";
import { Inject$HREFURLs, Inject$LocaleStrings, QueueEvents } from "./events.js";
import components from "./components.js";
import { Render$Examples, Render$FAQQuestions, Render$FAQQuickLinks, Render$FeatureCards, Render$FooterLinks, Render$HowToSteps, Render$PlanCards, Render$TestimonyCards } from "./renderers.js";


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
        Render$HowToSteps(LOCALE_STRINGS, DEFAULT_LOCALE);
        Render$Examples(LOCALE_STRINGS, DEFAULT_LOCALE);
        Render$TestimonyCards(LOCALE_STRINGS, DEFAULT_LOCALE);
        Render$FeatureCards(LOCALE_STRINGS, DEFAULT_LOCALE);
        Render$PlanCards(LOCALE_STRINGS, DEFAULT_LOCALE);
        Render$FAQQuickLinks(LOCALE_STRINGS, DEFAULT_LOCALE);
        Render$FAQQuestions(LOCALE_STRINGS, DEFAULT_LOCALE);
        Render$FooterLinks(LOCALE_STRINGS, DEFAULT_LOCALE);

        if (!disableLogs) console.log('---------------=====:: Queuing Events');
        QueueEvents();

        if (!disableLogs) console.log('---------------=====:: Injecting Data & Strings');
        Inject$HREFURLs();
        Inject$LocaleStrings(LOCALE_STRINGS);

        if (!disableLogs) console.log('---------------:: Out # Window.Onload');
    };
};

___InitializePage();