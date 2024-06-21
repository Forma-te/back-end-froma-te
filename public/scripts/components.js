import locale from "./locale.js";
import utils from "./utils.js";

function ___InitializeComponents () {
    const { disableLogs } = utils.___GetSiteConfigs();

    if (!disableLogs) console.log('---------------=====:: Components are ready');
};

export function FMTHowToStartStepRow ({ styleType='primary', theme='light', ...props }) {
    const {
        stepNumber,
        ctaStyleType='primary',
        ctaType='button',
        cta,
        disabledCTA=false,
        gotoURL='#',
        description
    } = props;

    const getCTA = (type) => {
        switch (type) {
            case 'button': return `
            <button type="button" class="fmt-button" data-styletype="${ctaStyleType}" data-theme="${theme}"${(disabledCTA) ? ' disabled' : ''}>
                ${cta}
            </button>
            `

            case 'link': return `
            <a href="${gotoURL}" class="fmt-button" data-styletype="${ctaStyleType}" data-theme="${theme}"${(disabledCTA) ? ' disabled' : ''}>
                ${cta}
            </a>
            `

            default: return '';
        };
    };

    return`
    <div class="fmt-step-row" data-styletype="${styleType}" data-theme="${theme}">
        <h5>${stepNumber}</h5>

        <p>${description}</p>

        ${getCTA(ctaType)}
    </div>
    `
};

export function FMTFaqQuickLink ({ styleType='primary', theme='dark', linkType='default', ...props }) {
    const {
        linkTitle,
        linkDescription,
        gotoURL='#',
        pageTitle
    } = props;

    const getIcon = (type) => {
        switch (type) {
            case "something": return '';

            default: return '<i class="icon fa fa-link"></i>'
        };
    };

    return`
    <div class="fmt-faq-quick-link" title="Ver página ${pageTitle}" data-event="link" data-gotourl="${gotoURL}" data-styletype="${styleType}" data-theme="${theme}">
        ${getIcon(linkType)}

        <h6>${linkTitle}</h6>

        <p>${linkDescription}</p>

        <a href="${gotoURL}" class="mt-2">
            <i class="fa fa-link"></i>

            <span>Ver página - ${pageTitle}</span>
        </a>
    </div>
    `
};

export function FMTFaqRow ({ styleType='primary', theme='dark', ...props }) {
    const {
        question,
        answer,
    } = props;

    return`
    <div class="fmt-faq-row" data-toggled="false" data-styletype="${styleType}" data-theme="${theme}">
        <p class="question">
            ${question}

            <i class="fa fa-chevron-down ml-auto"></i>
        </p>

        <p class="answer">
            ${answer}
        </p>
    </div>
    `
};

export function FMTFeatureCard ({ styleType='primary', theme='dark', cardType='default', ...props }) {
    const {
        title,
        description,
        icon
    } = props;

    return`
    <div class="fmt-feature-card" data-cardtype="${cardType}" data-styletype="${styleType}" data-theme="${theme}">
        <div class="icon">${icon}</div>

        <h4>${title}</h4>

        <p>${description}</p>
    </div>
    `
};

export function FMTFooterLinkGroup ({ styleType='primary', theme='dark', ...props }) {
    const {
        header,
        links
    } = props;

    const renderListItems = (links) => {
        return links.map(({ url, name }) => {
            return`<li><a href="${url}">${name}</a></li>`
        }).join(' ');
    };

    return`
    <div class="fmt-footer-link-group" data-styletype="${styleType}" data-theme="${theme}">
        ${(header.url === '#')
            ?   `<p class="title">${header.name}</p>`
            :   `<a href="${header.url}" class="title">${header.name}</a>`
        }

        <ul>${renderListItems(links)}</ul>
    </div>
    `
};

export function FMTPlanCard ({ styleType='primary', theme='dark', cardType='default', ...props }) {
    const {
        cardTitle,
        cardDescription,
        priceCurrency='AOA',
        priceValue,
        pricePlan,
        callToAction='CTA',
        featureList
    } = props;

    const _ctaStyleType = (cardType === 'priceless')
        ?   'primary'
        :   (cardType === 'call-to-action')
            ? 'special'
            : 'secondary'
    ;

    const _featureList = featureList.map(feat => `<li><i class="fa fa-check"></i>${feat}</li>`).join('');


    return`
    <div class="fmt-plan-card" data-cardtype="${cardType}" data-styletype="${styleType}" data-theme="${theme}">
        <h5 class="mb-6">${cardTitle}</h5>
        <p>${cardDescription}</p>

        <p class="price my-4">
            <span class="currency">${priceCurrency}</span>
            <span id="plan-${pricePlan}-price" class="value">${priceValue}</span>
        </p>

        <button type="button" class="fmt-button w-full my-4" data-styletype="${_ctaStyleType}" data-theme="${theme}">
            ${callToAction}
        </button>

        <ul>
            ${_featureList}
        </ul>
    </div>
    `
};

export function FMTTestimonyCard ({ styleType='primary', theme='light', ...props }) {
    const {
        profileSrc='#',
        userName='Name Name',
        userOccupation='Occupation',
        testimony
    } = props;

    return`
    <div class="fmt-testimony-card" data-styletype="${styleType}" data-theme="${theme}">
        <div class="profile" style="background-image: url('${profileSrc}');"></div>

        <p class="information">
            <span class="user-name">${userName}</span> <br />
            <span class="user-occupation">${userOccupation}</span>
        </p>

        <p class="testimony">
            ${testimony}
        </p>
    </div>
    `
};

export function FMTVideoCard ({ styleType='primary', theme='light', ...props }) {
    const {
        profileSrc='#',
        videoThumbnailSrc='#',
        videoTitle='Video title',
        cardType='default',
        userName,
        userOccupation='Occupation',
        localeLang=utils.___GetConstants().DEFAULT_LOCALE
    } = props;

    const isCTACard = cardType === 'call-to-action';

    const {
        examplesYourVideoTitle,
        examplesYourUserName,
        examplesYourUserOccupation,
    } = locale.___GetLocaleStrings(localeLang);

    const getCardProperties = (type) => {
        switch (type) {
            case 'call-to-action': return '';

            default: return `style="background-image: url('${videoThumbnailSrc}');"`;
        };
    };

    const getCardBody = (type) => {
        switch (type) {
            case 'call-to-action': return`
            <h4 id="examples:video-message" class="mt-auto mb-5"></h4>

            <a id="examples:cta" href="#" class="fmt-button mb-auto" data-styletype="special" data-theme="light">
            </a>
            `

            default: return`
            <button type="button" class="fmt-button" data-styletype="primary" data-theme="light">
                <i class="fa fa-play"></i>
            </button>
            `
        };
    };

    return`
    <div class="fmt-video-card" data-cardtype="${cardType}" data-styletype="${styleType}" data-theme="${theme}" ${getCardProperties(cardType)}>
        <div class="overlay"></div>

        <div class="header">
            <div class="profile" ${(isCTACard) ? '' : `style="background-image: url('${profileSrc}');"`}></div>

            <p>
                <span class="title">${(isCTACard) ? examplesYourVideoTitle : videoTitle}</span>

                <span class="name">${(isCTACard) ? examplesYourUserName : userName}</span>

                <span class="occupation">${(isCTACard) ? examplesYourUserOccupation : userOccupation}</span>
            </p>
        </div>

        ${getCardBody(cardType)}
    </div>
    `
};

const components = {
    ___InitializeComponents
};

export default components;
