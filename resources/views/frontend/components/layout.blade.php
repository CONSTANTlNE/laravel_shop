<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover"/>
    <title>Duo Mobile PWA Kit</title>
    <link rel="stylesheet" type="text/css" href="{{asset('frontassets/styles/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('frontassets/fonts/bootstrap-icons.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('frontassets/styles/style.css')}}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600;700;800&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">
    {{--    <link rel="manifest" href="_manifest.json">--}}
    <meta id="theme-check" name="theme-color" content="#FFFFFF">
    <link rel="apple-touch-icon" sizes="180x180" href="app/icons/icon-192x192.png">
    <style>
        .mx-lg-6 {
            margin-left: 5rem !important; /* 80px */
            margin-right: 5rem !important;
        }

        .bg-333{
            background-image: url({{asset('frontassets/images/test/1-1.webp')}});
        }
        .bg-144{
            background-image: url({{asset('frontassets/images/test/gradient-1.jpg')}});

        }
        .dynamic-width {
            width: clamp(360px, 50vw, 1000px);
        }

        .custom-h1{
            font-size: 28px;
            font-weight: 700;
            line-height: 1.4;
            font-feature-settings: 'case';
        }

        .content{
            /*margin-left:0;*/
            /*margin-right:0;*/
        }

    </style>
</head>

<body class="theme-light">

<div id="preloader">
    <div class="spinner-border color-highlight" role="status"></div>
</div>



<div id="page" class="mx-2 mx-sm-3 mx-md-4 mx-lg-5">
    @include('frontend.components.header')
    @include('frontend.components.footer')
    @include('frontend.components.sidebar')
    @include('frontend.components.colors')
    @include('frontend.components.notifications')
    @include('frontend.components.search')
    @include('frontend.components.categories')
    @include('frontend.components.cart')
{{--    Modals   --}}
    @include('frontend.components.modals.auth.login_modal')
    <div class="page-content header-clear-medium mx-2 mx-sm-3 mx-md-4 mx-lg-5">
        @yield('index')
        @yield('product-single')
        @yield('cart')
        @yield('front-categories')
        @yield('login')
        <div class="card card-style py-3">
            <div class="content px-2 text-center">
                <p class="mb-3">
                    Created by
                </p>
                <a href="https://1.envato.market/2ryjKA" target="_blank" class="default-link btn btn-m rounded-s gradient-highlight shadow-bg shadow-bg-s px-5 mb-0 mt-2">Get Duo Now</a>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-bottom rounded-m offcanvas-detached" id="menu-install-pwa-ios">
        <div class="content">
            <img src="app/icons/icon-128x128.png" alt="img" width="80" class="rounded-l mx-auto my-4">
            <h1 class="text-center font-800 font-20">Add Duo to Home Screen</h1>
            <p class="boxed-text-xl">
                Install Duo on your home screen, and access it just like a regular app. Open your Safari menu and tap
                "Add to Home Screen".
            </p>
            <a href="#"
               class="pwa-dismiss close-menu gradient-blue shadow-bg shadow-bg-s btn btn-s btn-full text-uppercase font-700  mt-n2"
               data-bs-dismiss="offcanvas">Maybe Later</a>
        </div>
    </div>
    <div class="offcanvas offcanvas-bottom rounded-m offcanvas-detached" id="menu-install-pwa-android">
        <div class="content">
            <img src="app/icons/icon-128x128.png" alt="img" width="80" class="rounded-m mx-auto my-4">
            <h1 class="text-center font-700 font-20">Install Duo</h1>
            <p class="boxed-text-l">
                Install Duo to your Home Screen to enjoy a unique and native experience.
            </p>
            <a href="#"
               class="pwa-install btn btn-m rounded-s text-uppercase font-900 gradient-highlight shadow-bg shadow-bg-s btn-full">Add
                to Home Screen</a><br>
            <a href="#" data-bs-dismiss="offcanvas"
               class="pwa-dismiss close-menu color-theme text-uppercase font-900 opacity-50 font-11 text-center d-block mt-n1">Maybe
                later</a>
        </div>
    </div>
</div>

<script src="{{asset('frontassets/scripts/bootstrap.min.js')}}"></script>
<script src="{{asset('frontassets/scripts/custom.js')}}"></script>
<script>
    function updateCardHeight() {
        const card = document.querySelectorAll('.custom-card');
console.log(card)
        let newHeight;

        if (window.innerWidth < 576) {
            // Mobile
            newHeight = 140;
        } else if (window.innerWidth < 992) {
            // Tablet
            newHeight = 200;
        } else {
            // Desktop
            newHeight = 280;
        }

        // Update attribute and CSS height
        card.forEach((card)=>{
            card.setAttribute('data-card-height', newHeight);
            card.style.height = newHeight + 'px';
        })

    }

    // Run on load & resize
    window.addEventListener('resize', updateCardHeight);
    updateCardHeight();
</script>
</body>
