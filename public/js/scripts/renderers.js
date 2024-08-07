import utils from "./utils.js"; 
import locale from "./locale.js";
import { FMTFaqQuickLink, FMTFaqRow, FMTFeatureCard, FMTFooterLinkGroup, FMTHowToStartStepRow, FMTPlanCard, FMTPlanForm, FMTTestimonyCard, FMTVideoCard, Table } from "./components.js";
import { getMembersTableConfig, getMenuForms, getProducersTableConfig, getSignaturesTableConfig } from "./getters.js";
import requests from "./requests.js";
import { ScheduleNotification } from "./events.js";

const {
    SignaturesAPI,
    UsersAPI
} =  requests;

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

export async function Render$MenuContent (
    localeStrings=locale.___GetLocaleStrings(utils.___GetConstants().DEFAULT_LOCALE), 
    localeLang=utils.___GetConstants().DEFAULT_LOCALE,
    menu, 
) {
    let headers, rows;
    
    const viewContainer = document.getElementById('menu-view');

    viewContainer.dataset.view = menu;

    switch (menu) {
        case 'main': { 
            viewContainer.innerHTML=`
            <section id="main-menu" class="menu-container" data-active="true">
                <h3>Links rápidos</h3>

                <section id="quick-links" class="menu-area">
                    <button type="button" data-event="goto-link" data-goto="/plans">
                        <i class="fa fa-link"></i>
                        <span id="quick-link:plans"></span>
                    </button>
                    
                    <button type="button" data-event="goto-link" data-goto="/signatures">
                        <i class="fa fa-link"></i>
                        <span id="quick-link:signatures"></span>
                    </button>

                    <button type="button" data-event="goto-link" data-goto="/producers">
                        <i class="fa fa-link"></i>
                        <span id="quick-link:producers"></span>
                    </button>

                    <button type="button" data-event="goto-link" data-goto="/members">
                        <i class="fa fa-link"></i>
                        <span id="quick-link:members"></span>
                    </button>

                    <button type="button" data-event="goto-link" data-goto="/platform">
                        <i class="fa fa-link"></i>
                        <span id="quick-link:platform"></span>
                    </button>
                </section>
            </section>
            `;

            break;
        };

        case 'plans': {
            const plansArray = [
                { id: 'basic-monthly', name: 'Básico Mensal', price: 15000 },
                { id: 'basic-trimestral', name: 'Básico Trimestral', price: 45000 },
                { id: 'basic-semestral', name: 'Básico Semestral', price: 90000 },
                { id: 'professional-monthly', name: 'Professional Mensal', price: 45000 }
            ];
    
            viewContainer.innerHTML=`
            <section id="plans-menu" class="menu-container" data-active="false">
                <section id="plan-creation" class="menu-area gap-y-2">
                    <button id="plan:create-plan" data-event="toggle-form" data-targetid="create-plan-form" type="button" class="w-full fmt-button" data-styletype="primary" data-theme="light">
                    </button>

                    ${getMenuForms(menu).createPlanForm}
                </section>
        
                <h3>Planos</h3>
        
                <section id="plan-list" class="menu-area gap-y-2">
                    ${plansArray.map(plan => { return FMTPlanForm(plan) }).join(' ')}
                </section>
            </section>
            `;
            
            break;
        };

        case 'signatures': {
            ({
                headers,
                rows
            } = await (getSignaturesTableConfig()));
            
            viewContainer.innerHTML=`
            <section id="signatures-list-menu" class="menu-container" data-active="false">
                <h3>Gestão de assinaturas solicitadas</h3>
        
                <section id="signatures-list" class="menu-area">
                    <div class="w-full flex flex-row justify-start items-center mb-3 gap-x-2">
                        <button type="button" id="signatures:signature-tab" class="tab" data-currenttable="signature-requests-table" data-eventid="signatures" data-active="true" data-event="switch-tables"></button>
                        <button type="button" id="signatures:requests-tab" class="tab" data-currenttable="signatures-table" data-eventid="signatures" data-active="false" data-event="switch-tables"></button>
                    </div>

                    <div class="table-search">
                        <i class="fa fa-search"></i>
                        <input id="search-signature-table" type="text" />
                    </div>

                    ${Table({ 
                        id: 'signatures-table',
                        headers,
                        rows,
                        withView: true,
                    })}

                    <div class="table-pagination">
                        <span>A mostrar ${rows.length}</span>

                        <button type="button" class="ml-auto">
                            <i class="fa fa-arrow-left"></i>
                        </button>

                        ${Array.from(Array(4)).map((_, idx) => { return`
                            <button type="button">${idx + 1}</button>
                        `}).join(' ')}

                        <button type="button">
                            <i class="fa fa-arrow-right"></i>
                        </button>
                    </div>
                </section>
            </section>
            `;
            
            break;
        }

        case 'producers': {
            ({
                headers,
                rows
            } = await (getProducersTableConfig()));

            viewContainer.innerHTML=`
            <section id="producers-list-menu" class="menu-container">
                <h3>Listagem</h3>

                <section id="producers-list" class="menu-area">
                    <div class="w-full flex flex-row justify-start items-center mb-3 gap-x-2">
                        <button type="button" id="producers:producers-tab" class="tab" data-currenttable="producers-requests-table" data-eventid="producers" data-active="true" data-event="switch-tables"></button>
                        <button type="button" id="producers:requests-tab" class="tab" data-currenttable="producers-table" data-eventid="producers" data-active="false" data-event="switch-tables"></button>
                    </div>

                    <div class="table-search">
                        <i class="fa fa-search"></i>
                        <input id="search-producers-table" type="text" />
                    </div>

                    ${Table({ 
                        id: 'producers-table',
                        headers,
                        rows,
                        withView: true,
                    })}

                    <div class="table-pagination">
                        <span>A mostrar ${rows.length}</span>

                        <button type="button" class="ml-auto">
                            <i class="fa fa-arrow-left"></i>
                        </button>

                        ${Array.from(Array(4)).map((_, idx) => { return`
                            <button type="button">${idx + 1}</button>
                        `}).join(' ')}

                        <button type="button">
                            <i class="fa fa-arrow-right"></i>
                        </button>
                    </div>
                </section>
            </section>
            `;
            
            break;
        }

        case 'members': {
            ({
                headers,
                rows
            } = await (getMembersTableConfig()));

            viewContainer.innerHTML=`
            <section id="members-menu" class="menu-container" data-active="false">            
                <section id="member-registration" class="menu-area gap-y-2">
                    <button id="member:create-member" data-event="toggle-form" data-targetid="create-member-form" type="button" class="w-full fmt-button" data-styletype="primary" data-theme="light">
                    </button>

                    ${getMenuForms(menu)}
                </section>

                <h3>Listagem</h3>

                <section id="members-list" class="menu-area">
                    <div class="table-search">
                        <i class="fa fa-search"></i>
                        <input id="search-members-table" type="text" />
                    </div>

                    ${Table({ 
                        id: 'members-table',
                        headers,
                        rows
                    })}

                    <div class="table-pagination">
                        <span>A mostrar ${rows.length}</span>

                        <button type="button" class="ml-auto">
                            <i class="fa fa-arrow-left"></i>
                        </button>

                        ${Array.from(Array(4)).map((_, idx) => { return`
                            <button type="button">${idx + 1}</button>
                        `}).join(' ')}

                        <button type="button">
                            <i class="fa fa-arrow-right"></i>
                        </button>
                    </div>
                </section>
            </section>
            `;
            
            break;
        }

        case 'platform': {
            viewContainer.innerHTML=`
            <section id="platform-menu" class="menu-container" data-active="false">
                <h3>Quem somos</h3>

                <section id="who-are-we" class="menu-area gap-y-2">
                </section>

                <h3>Benefícios</h3>

                <section id="benefits" class="menu-area gap-y-2">
                </section>

                <h3>Quem usa</h3>

                <section id="who-uses-it" class="menu-area gap-y-2">
                </section>

                <h3>Contactos</h3>

                <section id="contacts" class="menu-area gap-y-2">
                </section>

                <h3>Central de ajuda</h3>

                <section id="help-center" class="menu-area gap-y-2">
                </section>

                <h3>Funcionalidades</h3>

                <section id="functionalities" class="menu-area gap-y-2">
                </section>

                <h3>Termos de uso</h3>

                <section id="terms" class="menu-area gap-y-2">
                </section>

                <h3>Políticas de privacidade</h3>

                <section id="policy" class="menu-area gap-y-2">
                </section>

                <h3>Categoria</h3>

                <section id="categories" class="menu-area gap-y-2">
                </section>
            </section>
            `;
            
            break;
        }
    
        default: viewContainer.innerHTML=''; break;
    };
};

export async function Render$ProducerTableDataView (rowId, tableId) {
    const rowView = document.getElementById(`${tableId}-view-${rowId}`);

    // await new UsersAPI().GetProducer(rowId, ({ data=null, error=null }) => {
    //     if (error !== null) ScheduleNotification('get-producer-error');

    //     else {
    //         //Iterate data to render the div
    //         rowView.innerHTML=''
    //     }
    // });

    rowView.innerHTML=`
    <div class="producer-data">
        Producer data
    </div>
    `;

    rowView.dataset.toggled = 'true';
};

export async function Render$SignatureTableDataView (rowId, tableId) {
    const rowView = document.getElementById(`${tableId}-view-${rowId}`);

    // await new SignaturesAPI().GetSignature(rowId, ({ data=null, error=null }) => {
    //     if (error !== null) ScheduleNotification('get-signature-error');

    //     else {
    //         //Iterate data to render the div
               //rowView.innerHTML=''
    //     }
    // });

    const {
        transactionNumber='4B7334B',
        plan='Básico Trimestral',
        months=3,
        price='45.000,00 AOA',
        date=new Date().toLocaleString()
    } = {};

    rowView.innerHTML=`
    <div class="signature-data">
        <div class="flex flex-row justify-start items-start w-full gap-x-3">
            <p>
                <span class="title">Transação Nº</span>
                <span class="data">${transactionNumber}</span>
            </p>

            <p>
                <span class="title">Plano</span>
                <span class="data">${plan}</span>
            </p>

            <p>
                <span class="title">Mensalidade</span>
                <span class="data">${months}</span>
            </p>

            <p>
                <span class="title">Preço Total</span>
                <span class="data">${price}</span>
            </p>

            <p>
                <span class="title">Data</span>
                <span class="data">${date}</span>
            </p>
        </div>
        
        <div class="form flex flex-row justify-between items-end w-full">
            <label for="expiry-date">
                <span>Data de vencimento</span>
                <input type="date" id="expiry-date" name="expiry-date" data-signatureid="${rowId}"/>
            </label>

            <button type="button" data-action="confirm-payment" data-entity="signature" data-event="api" class="fmt-button" data-styletype="primary" data-theme="light">
                Confirmar pagamento
            </button>
        </div>
    </div>
    `;

    rowView.dataset.toggled = 'true';
};