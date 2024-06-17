import utils from "./utils.mjs"; 
import locale from "./locale.mjs";
import { FMTFaqQuickLink, FMTFaqRow, FMTFeatureCard, FMTFooterLinkGroup, FMTHowToStartStepRow, FMTPlanCard, FMTTestimonyCard, FMTVideoCard } from "./components.mjs";

export function Render$Examples (
    localeStrings=locale.___GetLocaleStrings(utils.___GetConstants().DEFAULT_LOCALE), 
    localeLang=utils.___GetConstants().DEFAULT_LOCALE
) {
    const containerElement = document.getElementById('example-collection');

    [
        [
            {
                profileSrc: './img/jpeg/model-7.jpg',
                videoThumbnailSrc: './img/jpeg/model-7.jpg',
                videoTitle: 'Video title',
                userName: 'Name name',
                userOccupation: 'Occupation',
            },
            {
                profileSrc: './img/jpeg/model-1.jpg',
                videoThumbnailSrc: './img/jpeg/model-1.jpg',
                videoTitle: 'Video title',
                userName: 'Name name',
                userOccupation: 'Occupation',
            },
            {
                profileSrc: './img/jpeg/model-3.jpg',
                videoThumbnailSrc: './img/jpeg/model-3.jpg',
                videoTitle: 'Video title',
                userName: 'Name name',
                userOccupation: 'Occupation',
            },
            {
                profileSrc: './img/jpeg/model-4.jpg',
                videoThumbnailSrc: './img/jpeg/model-4.jpg',
                videoTitle: 'Video title',
                userName: 'Name name',
                userOccupation: 'Occupation',
            },
            {
                profileSrc: './img/jpeg/model-5.jpg',
                videoThumbnailSrc: './img/jpeg/model-5.jpg',
                videoTitle: 'Video title',
                userName: 'Name name',
                userOccupation: 'Occupation',
            },
            {
                profileSrc: './img/jpeg/model-6.jpg',
                videoThumbnailSrc: './img/jpeg/model-6.jpg',
                videoTitle: 'Video title',
                userName: 'Name name',
                userOccupation: 'Occupation',
            },
            {
                cardType: 'call-to-action',
                localeLang: localeLang
            }
        ]
    ].forEach(arrayProps => containerElement.insertAdjacentHTML('beforeend', `
        <div class="row"> <div class="scroller" data-direction="horizontal">
            ${arrayProps.map(props => FMTVideoCard(props)).join(' ')}
        </div> </div>
    `));
};

export function Render$FAQQuestions (
    localeStrings=locale.___GetLocaleStrings(utils.___GetConstants().DEFAULT_LOCALE), 
    localeLang=utils.___GetConstants().DEFAULT_LOCALE
) {
    const containerElement = document.getElementById('faq-question-collection');

    [
        { 
            question: localeStrings.faqQuestion1,
            answer: localeStrings.faqAnswer1
        },
        { 
            question: localeStrings.faqQuestion2,
            answer: localeStrings.faqAnswer2
        },
        { 
            question: localeStrings.faqQuestion3,
            answer: localeStrings.faqAnswer3
        },
        { 
            question: localeStrings.faqQuestion4,
            answer: localeStrings.faqAnswer4
        }
    ].forEach(props => containerElement.insertAdjacentHTML('beforeend', FMTFaqRow(props)));
};

export function Render$FAQQuickLinks (
    localeStrings=locale.___GetLocaleStrings(utils.___GetConstants().DEFAULT_LOCALE), 
    localeLang=utils.___GetConstants().DEFAULT_LOCALE
) {
    const containerElement = document.getElementById('faq-quick-links');

    [
        { 
            linkTitle: localeStrings.faqQuickLink2Title,
            linkType: localeStrings.faqQuickLink2Type,
            linkDescription: localeStrings.faqQuickLink2Description,
            gotoURL: localeStrings.faqQuickLink2PageURL,
            pageTitle: localeStrings.faqQuickLink2PageTitle
        },
        { 
            linkTitle: localeStrings.faqQuickLink1Title,
            linkType: localeStrings.faqQuickLink1Type,
            linkDescription: localeStrings.faqQuickLink1Description,
            gotoURL: localeStrings.faqQuickLink1PageURL,
            pageTitle: localeStrings.faqQuickLink1PageTitle
        }
    ].forEach(props => containerElement.insertAdjacentHTML('beforeend', FMTFaqQuickLink(props)));
};

export function Render$FeatureCards (
    localeStrings=locale.___GetLocaleStrings(utils.___GetConstants().DEFAULT_LOCALE), 
    localeLang=utils.___GetConstants().DEFAULT_LOCALE
) {
    const containerElement = document.getElementById('feature-list');

    [
        [
            { 
                description: localeStrings.specialFeaturesDescription1,
                icon: localeStrings.specialFeaturesIcon1,
                title: localeStrings.specialFeaturesTitle1
            },
            { 
                description: localeStrings.specialFeaturesDescription2,
                icon: localeStrings.specialFeaturesIcon2,
                title: localeStrings.specialFeaturesTitle2
            },
            { 
                description: localeStrings.specialFeaturesDescription3,
                icon: localeStrings.specialFeaturesIcon3,
                title: localeStrings.specialFeaturesTitle3
            }
        ],
        [
            { 
                description: localeStrings.specialFeaturesDescription1,
                icon: localeStrings.specialFeaturesIcon1,
                title: localeStrings.specialFeaturesTitle1
            },
            { 
                description: localeStrings.specialFeaturesDescription2,
                icon: localeStrings.specialFeaturesIcon2,
                title: localeStrings.specialFeaturesTitle2
            },
            { 
                description: localeStrings.specialFeaturesDescription3,
                icon: localeStrings.specialFeaturesIcon3,
                title: localeStrings.specialFeaturesTitle3
            }
        ],
    ].forEach(arrayProps => containerElement.insertAdjacentHTML('beforeend', `
        <div class="row">
            ${arrayProps.map(props => FMTFeatureCard(props)).join(' ')}
        </div>
    `));
};

export function Render$FooterLinks (
    localeStrings=locale.___GetLocaleStrings(utils.___GetConstants().DEFAULT_LOCALE), 
    localeLang=utils.___GetConstants().DEFAULT_LOCALE
) {
    const containerElement = document.getElementById('footer-links');

    [
        { 
            header: { 
                name: localeStrings.footerLinkGroup1Name,
                url: localeStrings.footerLinkGroup1URL
            },
            links: Array.from(Array(3), (_, i) => {
                return {
                    name: localeStrings[`footerLinkGroup1Link${i + 1}Name`],
                    url: localeStrings[`footerLinkGroup1Link${i + 1}URL`]
                }
            })
        },
        { 
            header: { 
                name: localeStrings.footerLinkGroup2Name,
                url: localeStrings.footerLinkGroup2URL
            },
            links: Array.from(Array(3), (_, i) => {
                return {
                    name: localeStrings[`footerLinkGroup2Link${i + 1}Name`],
                    url: localeStrings[`footerLinkGroup2Link${i + 1}URL`]
                }
            })
        },
        { 
            header: { 
                name: localeStrings.footerLinkGroup3Name,
                url: localeStrings.footerLinkGroup3URL
            },
            links: Array.from(Array(3), (_, i) => {
                return {
                    name: localeStrings[`footerLinkGroup3Link${i + 1}Name`],
                    url: localeStrings[`footerLinkGroup3Link${i + 1}URL`]
                }
            })
        },
    ].forEach(props => containerElement.insertAdjacentHTML('beforeend', FMTFooterLinkGroup(props)));
};

export function Render$HowToSteps (
    localeStrings=locale.___GetLocaleStrings(utils.___GetConstants().DEFAULT_LOCALE), 
    localeLang=utils.___GetConstants().DEFAULT_LOCALE
) {
    const containerElement = document.getElementById('howto-steps');

    const propsArray = [
        { 
            ctaStyleType: 'special',
            cta: localeStrings.howtoStartCTA1,
            ctaType: 'link',
            gotoURL: localeStrings.howtoStartURL1,
            description: localeStrings.howtoStartDescription1
        },
        { 
            cta: localeStrings.howtoStartCTA2,
            ctaType: 'link',
            description: localeStrings.howtoStartDescription2,
            gotoURL: localeStrings.howtoStartURL2,
        },
        { 
            ctaStyleType: 'secondary',
            cta: localeStrings.howtoStartCTA3,
            disabledCTA: true,
            description: localeStrings.howtoStartDescription3
        },
    ]
    
    propsArray.forEach((props, idx) => containerElement.insertAdjacentHTML('beforeend', `
        ${FMTHowToStartStepRow({ stepNumber: (idx + 1), ...props })}

        ${((idx + 1) === propsArray.length) ? '' : '<i class="fa fa-arrow-down"></i>'}
    `));
};

export function Render$PlanCards (
    localeStrings=locale.___GetLocaleStrings(utils.___GetConstants().DEFAULT_LOCALE), 
    localeLang=utils.___GetConstants().DEFAULT_LOCALE
) {
    const {
        DEFAULT_PRICING,
        plan_1_monthly_price,
        plan_1_yearly_price,
        plan_2_monthly_price,
        plan_2_yearly_price,
    } = utils.___GetConstants();

    const containerElement = document.getElementById('pricing-cards');

    [
        { 
            cardTitle: localeStrings.plan1Name, 
            cardDescription: localeStrings.plan1Description, 
            pricePlan: 1,
            priceValue: (DEFAULT_PRICING === 'yearly') ? plan_1_yearly_price : plan_1_monthly_price, 
            callToAction: localeStrings.plan1CTA, 
            featureList: localeStrings.plan1Features
        },
        { 
            cardType:'call-to-action', 
            cardTitle: localeStrings.plan2Name, 
            cardDescription: localeStrings.plan2Description, 
            pricePlan: 2,
            priceValue: (DEFAULT_PRICING === 'yearly') ? plan_2_yearly_price : plan_2_monthly_price, 
            callToAction: localeStrings.plan2CTA, 
            featureList: localeStrings.plan2Features
        },
        { 
            cardType:'priceless',
            cardTitle: localeStrings.plan3Name, 
            cardDescription: localeStrings.plan3Description, 
            pricePlan: 3,
            priceValue: 0, 
            callToAction: localeStrings.plan3CTA, 
            featureList: localeStrings.plan3Features
        },
    ].forEach(props => containerElement.insertAdjacentHTML('beforeend', FMTPlanCard(props)));
};

export function Render$TestimonyCards (
    localeStrings=locale.___GetLocaleStrings(utils.___GetConstants().DEFAULT_LOCALE), 
    localeLang=utils.___GetConstants().DEFAULT_LOCALE
) {
    const containerElement = document.getElementById('testimony-collection');

    [
        [
            { 
                profileSrc: './img/jpeg/profile-2.jpg',
                userName: localeStrings.testimony1UserName,
                userOccupation: localeStrings.testimony1UserOccupation,
                testimony: localeStrings.testimony1
            },
            { 
                profileSrc: './img/jpeg/profile-1.jpg',
                userName: localeStrings.testimony2UserName,
                userOccupation: localeStrings.testimony2UserOccupation,
                testimony: localeStrings.testimony2
            },
            { 
                profileSrc: './img/jpeg/profile-5.jpg',
                userName: localeStrings.testimony3UserName,
                userOccupation: localeStrings.testimony3UserOccupation,
                testimony: localeStrings.testimony3
            }
        ],
        [
            { 
                profileSrc: './img/jpeg/profile-7.jpg',
                userName: localeStrings.testimony1UserName,
                userOccupation: localeStrings.testimony1UserOccupation,
                testimony: localeStrings.testimony1
            },
            { 
                profileSrc: './img/jpeg/profile-3.jpg',
                userName: localeStrings.testimony1UserName,
                userOccupation: localeStrings.testimony1UserOccupation,
                testimony: localeStrings.testimony1
            },
            { 
                profileSrc: './img/jpeg/profile-4.jpg',
                userName: localeStrings.testimony2UserName,
                userOccupation: localeStrings.testimony2UserOccupation,
                testimony: localeStrings.testimony2
            },
            { 
                profileSrc: './img/jpeg/profile-6.jpg',
                userName: localeStrings.testimony3UserName,
                userOccupation: localeStrings.testimony3UserOccupation,
                testimony: localeStrings.testimony3
            }
        ],
    ].forEach(arrayProps => containerElement.insertAdjacentHTML('beforeend', `
        <div class="row"> <div class="scroller" data-direction="horizontal">
            ${arrayProps.map(props => FMTTestimonyCard(props)).join(' ')}
        </div> </div>
    `));
};