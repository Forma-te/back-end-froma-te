<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FORMA-TE | Admin</title>
    <link rel="icon" href="./favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="{{ '/assets/css/global_.css' }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body data-page="admin">
    <div class="overlay" data-parent="body" data-toggled="false"></div>

    <div id="notification" data-active="false" data-styletype="primary" data-theme="light"></div>

    <aside id="side-menu" data-toggled="false">
        <button id="side-menu-close-btn" type="button">
            <i class="fa fa-angle-right"></i>
        </button>

        <p id="logo" class="text-3xl">FORMA-TE</p>

        <hr class="my-3" />

        <p id="side-menu:title1" class="title"></p>

        <a id="side-menu-item:main" href="{{ route('admin.index') }}" data-rendermenu="main" data-active="true" data-componenttype="sidemenu-link"></a>
        <a id="side-menu-item:plans" href="{{ route('plans.index') }}" data-rendermenu="plans" data-active="false" data-componenttype="sidemenu-link"></a>
        <a id="side-menu-item:signatures" href="{{ route('user.requests.all')}}" data-rendermenu="signatures" data-active="false" data-componenttype="sidemenu-link"></a>
        <a id="side-menu-item:producers" href="./admin-producers.html" data-rendermenu="producers" data-active="false" data-componenttype="sidemenu-link"></a>
        <a id="side-menu-item:members" href="./admin-members.html" data-rendermenu="members" data-active="false" data-componenttype="sidemenu-link"></a>
        <a id="side-menu-item:platform" href="./admin-platform.html" data-rendermenu="platform" data-active="false" data-componenttype="sidemenu-link"></a>

        <hr class="my-3" />

        <p class="w-full text-center opacity-50 mt-auto">
            <span id="side-menu:copyright-1"></span> <br />
            <span id="side-menu:copyright-2"></span>
        </p>
    </aside>

    <nav id="nav-bar">
        <button id="side-menu-open-btn" type="button">
            <i class="fa fa-bars"></i>
        </button>

        <p id="breadcrumbs">
        </p>
    </nav>

     @yield('contect')

    <footer data-componenttype="container" data-theme="dark">
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

    <script type="module" src="{{ asset('js/admin.js') }}"></script>
</body>

</html>
