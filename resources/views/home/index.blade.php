<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FORMA-TE</title>
    <link rel="icon" href="./favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="{{ '/assets/css/global_.css' }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="overlay" data-parent="body" data-toggled="false"></div>

    <nav id="side-bar" data-toggled="false">
        <div class="w-full flex flex-row justify-between items-center">
            <a class="ml-9" href="#howto-start" data-componenttype="sidebar-link">Como Começar</a>

            <button id="side-bar-close-btn" type="button">
                <i class="fa fa-close"></i>
            </button>
        </div>

        <a class="mx-5" href="#examples" data-componenttype="sidebar-link">Exemplos</a>
        <a href="#special-features" data-componenttype="sidebar-link">Funcionalidades</a>
    </nav>

    <nav id="nav-bar" class="w-full flex flex-row justify-start items-center p-5">
        <p class="font-black text-3xl">FORMA-TE</p>

        <a class="ml-9" href="#howto-start">Como Começar</a>
        <a class="mx-5" href="#examples">Exemplos</a>
        <a href="#special-features">Funcionalidades</a>

        <button type="button" class="fmt-button ml-auto" data-styletype="primary" data-theme="light">
            Dinamiza o teu negócio
        </button>

        <button id="side-bar-open-btn" type="button">
            <i class="fa fa-bars"></i>
        </button>
    </nav>

    <main>
        <section id="hero" data-componenttype="container" data-theme="light">
            <h1 id="hero:title"></h1>

            <p id="hero:description" class="text-center" data-componenttype="description"></p>

            <div class="button-group">
                <button id="hero:cta-1" type="button" class="fmt-button" data-styletype="primary" data-theme="light">
                </button>

                <button id="hero:cta-2" type="button" class="fmt-button" data-styletype="secondary" data-theme="light">
                </button>
            </div>
        </section>

        <!-- <section id="howit-works" data-componenttype="container" data-theme="light">

        </section> -->

        <section id="howto-start" data-componenttype="container" data-theme="light">
            <h3 id="howto-start:title"></h3>

            <p id="howto-start:description" data-componenttype="description"></p>

            <div id="howto-steps">
            </div>
        </section>

        <!-- <section id="features" data-componenttype="container" data-theme="light">
            <h3 id="features:title" ></h3>

            <div class="fmt-image-card">
                <h5></h5>
                <p></p>
            </div>
        </section> -->

        <section id="features-cta" data-componenttype="container" data-theme="light">
            <div id="section-grid">
                <h3 id="features-cta:title"></h3>

                <ul class="my-5">
                    <li id="features-cta:item-1"></li>
                    <li id="features-cta:item-2"></li>
                    <li id="features-cta:item-3"></li>
                </ul>

                <div id="features-cta-buttons" class="w-full flex flex-row justify-end items-end gap-x-1">
                    <button id="features-cta:cta-1" type="button" class="fmt-button w-full" data-styletype="primary"
                        data-theme="light">
                    </button>

                    <button id="features-cta:cta-2" type="button" class="fmt-button w-full" data-styletype="secondary"
                        data-theme="light">
                    </button>
                </div>

                <div id="features-cta-video">
                    <button type="button" class="fmt-button" data-styletype="primary" data-theme="light">
                        <i class="fa fa-play"></i>
                    </button>
                </div>
            </div>
        </section>

        <section id="examples" data-componenttype="container" data-theme="light">
            <h3 id="examples:title"></h3>

            <p id="examples:description" data-componenttype="description"></p>

            <div id="example-collection">
            </div>
        </section>

        <section id="testimonies" data-componenttype="container" data-theme="light">
            <h3 id="testimonies:title"></h3>

            <div id="testimony-collection" class="w-full">
            </div>
        </section>

        <section id="special-features" data-componenttype="container" data-theme="dark">
            <h3 id="special-features:title"></h3>

            <p id="special-features:description" data-componenttype="description"></p>

            <div id="feature-list" class="w-full">
            </div>
        </section>

        <section id="pricing" data-componenttype="container" data-theme="dark">
            <h3 id="pricing:title"></h3>

            <p id="pricing:description" data-componenttype="description"></p>

            <div class="fmt-plan-toggler mt-6 mb-5" data-styletype="primary" data-theme="dark">
                <button id="monthly-pricing-toggler" data-toggled="false"></button>
                <button id="yearly-pricing-toggler" data-toggled="true"></button>
            </div>

            <div id="pricing-cards" class="w-full">
            </div>

            <button id="pricing:comparison" type="button" class="fmt-button w-full mt-9" data-styletype="secondary"
                data-theme="dark">
            </button>
        </section>

        <section id="faq-links" data-componenttype="container" data-theme="dark">
            <h3 id="faq:title-1"></h3>

            <div id="faq-quick-links" class="w-full mt-4">
            </div>
        </section>

        <section id="faq-questions" data-componenttype="container" data-theme="dark">
            <h3 id="faq:title-2"></h3>

            <div id="faq-question-collection" class="w-full mt-4">
            </div>
        </section>

    </main>

    <footer class="w-full flex flex-col justify-center items-center py-3" data-componenttype="container"
        data-theme="dark">
        <section id="footer-links"></section>

        <section id="footer-social-media">
            <a id="goto:fmt-instagram" target="_blank" rel="noreferrer" class="fmt-social-link-button"
                data-styletype="primary" data-theme="dark">
                <img src="{{'/assets/img/png/ic_instagram.png'}}" alt="instagram's logo" />
            </a>

            <a id="goto:fmt-facebook" target="_blank" rel="noreferrer" class="fmt-social-link-button mx-2"
                data-styletype="primary" data-theme="dark">
                <img src="{{'/assets/img/png/ic_facebook.png'}}" alt="facebook's logo" />
            </a>

            <a id="goto:fmt-twitterx" target="_blank" rel="noreferrer" class="fmt-social-link-button"
                data-styletype="primary" data-theme="dark">
                <img src="{{'/assets/img/png/ic_x_twitter.png'}}" alt="twitter-x's logo" />
            </a>
        </section>

        <p id="footer-meta" class="w-full text-center opacity-50">
            <span id="footer:copyright-1"></span> <br />
            <span id="footer:copyright-2"></span>
        </p>
    </footer>

    <script type="module" src="{{'/scripts/main.js'}}"></script>
</body>

</html>
