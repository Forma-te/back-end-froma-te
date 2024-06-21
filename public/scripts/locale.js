function ___GetLocaleStrings (localeLang='') {
    const _pt = {
        'hero:title': 'Hero about the site <span>special stuff</span> in a special place',
        'hero:description': 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat',
        'hero:cta-1': 'CTA',
        'hero:cta-2': 'CTA',

        'howto-start:title': 'Como Começar',
        'howto-start:description': 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat',

        'howtoStartDescription1': 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt',
        'howtoStartCTA1': 'Cria um conta',
        'howtoStartURL1': '#',

        'howtoStartDescription2': 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt',
        'howtoStartCTA2': 'Escolha um plano',
        'howtoStartURL2': '#pricing',

        'howtoStartDescription3': 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt',
        'howtoStartCTA3': 'Crie um produto',

        'features:title': 'Funcionalidades',

        'features-cta:title': 'Sobre funcionalidades',
        'features-cta:item-1': 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt',
        'features-cta:item-2': 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt',
        'features-cta:item-3': 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt',
        'features-cta:cta-1': 'CTA',
        'features-cta:cta-2': 'CTA',

        'examples:title': 'Exemplos',
        'examples:description': 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat',

        'examplesYourVideoTitle': 'A tua aula',
        'examplesYourUserName': 'A tua inciativa',
        'examplesYourUserOccupation': 'Quem tu és',
        'examples:video-message': 'Não espere mais, partilhe com o mundo as suas ideias',
        'examples:cta': 'Sê o próximo',

        'testimonies:title': 'Testemunhos',

        'testimony1UserName': 'Name 1',
        'testimony1UserOccupation': 'Occupation 1',
        'testimony1': 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',

        'testimony2UserName': 'Name 2',
        'testimony2UserOccupation': 'Occupation 2',
        'testimony2': 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',

        'testimony3UserName': 'Name 3',
        'testimony3UserOccupation': 'Occupation 3',
        'testimony3': 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
        
        'mid:cta': 'Lorem ipsum dolor',

        'special-features:title': 'Funcionalidades espcializadas',
        'special-features:description': 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat',
        'special-features:cta': 'Lorem ipsum dolor',

        'specialFeaturesIcon1': '<i class="fa fa-play"></i>',
        'specialFeaturesTitle1': 'Lorem ipsum dolor',
        'specialFeaturesDescription1': 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur',

        'specialFeaturesIcon2': '<i class="fa fa-play"></i>',
        'specialFeaturesTitle2': 'Lorem ipsum dolor',
        'specialFeaturesDescription2': 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur',
        
        'specialFeaturesIcon3': '<i class="fa fa-play"></i>',
        'specialFeaturesTitle3': 'Lorem ipsum dolor',
        'specialFeaturesDescription3': 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur',

        'pricing:title': 'Planos e Preços',
        'pricing:description': 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
        'pricing:comparison': 'Veja uma comparação mais detalhada dos nossos planos',

        'plan1Name': 'Plano 1',
        'plan1Description': 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore',
        'plan1CTA': 'CTA',
        'plan1Features': [
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit'
        ],
        
        'plan2Name': 'Plano 2',
        'plan2Description': 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore',
        'plan2CTA': 'CTA',
        'plan2Features': [
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit'
        ],

        'plan3Name': 'Plano 3',
        'plan3Description': 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore',
        'plan3CTA': 'CTA',
        'plan3Features': [
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit'
        ],

        'monthly-pricing-toggler': 'Mensal',
        'yearly-pricing-toggler': 'Anual <span>Desconto %</span>',

        'faq:title-1': 'FAQ (Links rápidos)',

        'faqQuickLink1Title': 'Lorem ipsum dolor',
        'faqQuickLink1Type': 'link',
        'faqQuickLink1Description': 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
        'faqQuickLink1PageTitle': 'Duis aute irure dolor in reprehenderit',
        'faqQuickLink1PageURL': '#',

        'faqQuickLink2Title': 'Lorem ipsum dolor',
        'faqQuickLink2Type': 'link',
        'faqQuickLink2Description': 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
        'faqQuickLink2PageTitle': 'Duis aute irure dolor in reprehenderit',
        'faqQuickLink2PageURL': '#',

        'faq:title-2': 'FAQ',

        'faqQuestion1': 'Lorem ipsum dolor?',
        'faqAnswer1': 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',

        'faqQuestion2': 'Lorem ipsum dolor?',
        'faqAnswer2': 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',

        'faqQuestion3': 'Lorem ipsum dolor?',
        'faqAnswer3': 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',

        'faqQuestion4': 'Lorem ipsum dolor?',
        'faqAnswer4': 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',

        'faqQuestion5': 'Lorem ipsum dolor?',
        'faqAnswer5': 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',

        'last:cta': 'Lorem ipsum dolor',
        
        'footerLinkGroup1Name': 'Lorem ipsum dolor',
        'footerLinkGroup1URL': '#',
        'footerLinkGroup1Link1Name': 'Duis aute irure dolor',
        'footerLinkGroup1Link1URL': '#',
        'footerLinkGroup1Link2Name': 'Duis aute irure dolor',
        'footerLinkGroup1Link2URL': '#',
        'footerLinkGroup1Link3Name': 'Duis aute irure dolor',
        'footerLinkGroup1Link3URL': '#',

        'footerLinkGroup2Name': 'Lorem ipsum dolor',
        'footerLinkGroup2URL': '#',
        'footerLinkGroup2Link1Name': 'Duis aute irure dolor',
        'footerLinkGroup2Link1URL': '#',
        'footerLinkGroup2Link2Name': 'Duis aute irure dolor',
        'footerLinkGroup2Link2URL': '#',
        'footerLinkGroup2Link3Name': 'Duis aute irure dolor',
        'footerLinkGroup2Link3URL': '#',

        'footerLinkGroup3Name': 'Lorem ipsum dolor',
        'footerLinkGroup3URL': '#',
        'footerLinkGroup3Link1Name': 'Duis aute irure dolor',
        'footerLinkGroup3Link1URL': '#',
        'footerLinkGroup3Link2Name': 'Duis aute irure dolor',
        'footerLinkGroup3Link2URL': '#',
        'footerLinkGroup3Link3Name': 'Duis aute irure dolor',
        'footerLinkGroup3Link3URL': '#',

        'footer:copyright-1': 'Forma-te © 2024',
        'footer:copyright-2': 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident'
    };

    switch (localeLang) {
        case 'pt': return _pt;
    
        default: return {
            pt: _pt    
        };
    }
};

const locale = {
    ___GetLocaleStrings
};

export default locale;