<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover"/>
    <title>SHOP</title>
    {{--    <link rel="stylesheet" type="text/css" href="{{asset('frontassets/styles/bootstrap.css')}}">--}}
    {{--    <link rel="stylesheet" type="text/css" href="{{asset('frontassets/fonts/bootstrap-icons.css')}}">--}}
    {{--    <link rel="stylesheet" type="text/css" href="{{asset('frontassets/styles/style.css')}}">--}}
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600;700;800&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">
    {{--    <link rel="manifest" href="_manifest.json">--}}
    <meta id="theme-check" name="theme-color" content="#FFFFFF">
    <meta name="htmx-config" content='{"selfRequestsOnly":false}'>
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('defaults/default_placeholder.png')}}">

    @vite([ 'resources/js/app.js'])
    <style>
        .mx-lg-6 {
            margin-left: 5rem !important; /* 80px */
            margin-right: 5rem !important;
        }

        .bg-333 {
            background-image: url({{asset('defaults/placeholder.jpeg')}});
        }

        .bg-144 {
            background-image: url({{asset('frontassets/images/test/gradient-1.jpg')}});

        }

        .dynamic-width {
            width: clamp(360px, 50vw, 1000px);
        }

        .custom-h1 {
            font-size: 28px;
            font-weight: 700;
            line-height: 1.4;
            font-feature-settings: 'case';
        }

        .content {
            /*margin-left:0;*/
            /*margin-right:0;*/
        }

        .product_card_height {
            height: 400px;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .bottom_center{
            position: absolute;
            bottom: 0;          /* stick to bottom */
            left: 50%;          /* move to horizontal center */
            transform: translateX(-50%); /* pull back by half width */
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            width: 100%;
        }


        @media (min-width: 768px) {
            .product_card_height {
                height: 600px;
            }
        }

        /* Desktops (min-width: 1024px) */
        @media (min-width: 1024px) {
            .product_card_height {
                height: 800px;
            }
        }

    </style>
    {{--    stiles for image upload --}}
    <style>
        /* Uniform preview grid */
        .preview {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 10px;
        }

        .preview-item {
            position: relative;
            width: 100%;
            aspect-ratio: 1 / 1; /* keep square tiles */
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            overflow: hidden;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .preview-img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* makes all images same visual size */
            display: block;
        }

        .preview-file {
            padding: 8px;
            font-size: 12px;
            text-align: center;
            color: #333;
        }

        .remove-btn {
            position: absolute;
            top: 4px;
            right: 4px;
            border: none;
            background: rgba(0, 0, 0, .5);
            color: red;
            width: 22px;
            height: 22px;
            line-height: 22px;
            border-radius: 50%;
            cursor: pointer;
        }

        .remove-btn:hover {
            background: rgba(0, 0, 0, .7);
        }

        /* Center layout when only one preview is present */
        .preview.preview-single {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .preview.preview-single .preview-item {
            width: 200px; /* constrain single item width */
            max-width: 70%;
        }
    </style>

    @stack('css')

</head>

<body class="theme-light" >
<div class="overlay" id="overlay" style="display:none;">
    {{--    <svg xmlns="http://www.w3.org/2000/svg" width="250" height="250" viewBox="0 0 24 24">--}}
    {{--        <g>--}}
    {{--            <rect width="2" height="5" x="11" y="1" fill="currentColor" opacity="0.14"/>--}}
    {{--            <rect width="2" height="5" x="11" y="1" fill="currentColor" opacity="0.29"--}}
    {{--                  transform="rotate(30 12 12)"/>--}}
    {{--            <rect width="2" height="5" x="11" y="1" fill="currentColor" opacity="0.43"--}}
    {{--                  transform="rotate(60 12 12)"/>--}}
    {{--            <rect width="2" height="5" x="11" y="1" fill="currentColor" opacity="0.57"--}}
    {{--                  transform="rotate(90 12 12)"/>--}}
    {{--            <rect width="2" height="5" x="11" y="1" fill="currentColor" opacity="0.71"--}}
    {{--                  transform="rotate(120 12 12)"/>--}}
    {{--            <rect width="2" height="5" x="11" y="1" fill="currentColor" opacity="0.86"--}}
    {{--                  transform="rotate(150 12 12)"/>--}}
    {{--            <rect width="2" height="5" x="11" y="1" fill="currentColor" transform="rotate(180 12 12)"/>--}}
    {{--            <animateTransform attributeName="transform" calcMode="discrete" dur="0.75s" repeatCount="indefinite"--}}
    {{--                              type="rotate"--}}
    {{--                              values="0 12 12;30 12 12;60 12 12;90 12 12;120 12 12;150 12 12;180 12 12;210 12 12;240 12 12;270 12 12;300 12 12;330 12 12;360 12 12"/>--}}
    {{--        </g>--}}
    {{--    </svg>--}}
    <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 24 24">
        <g>
            <rect width="2" height="5" x="11" y="1" fill="#110909" opacity="0.14"/>
            <rect width="2" height="5" x="11" y="1" fill="#110909" opacity="0.29" transform="rotate(30 12 12)"/>
            <rect width="2" height="5" x="11" y="1" fill="#110909" opacity="0.43" transform="rotate(60 12 12)"/>
            <rect width="2" height="5" x="11" y="1" fill="#110909" opacity="0.57" transform="rotate(90 12 12)"/>
            <rect width="2" height="5" x="11" y="1" fill="#110909" opacity="0.71" transform="rotate(120 12 12)"/>
            <rect width="2" height="5" x="11" y="1" fill="#110909" opacity="0.86" transform="rotate(150 12 12)"/>
            <rect width="2" height="5" x="11" y="1" fill="#110909" transform="rotate(180 12 12)"/>
            <animateTransform attributeName="transform" calcMode="discrete" dur="0.75s" repeatCount="indefinite"
                              type="rotate"
                              values="0 12 12;30 12 12;60 12 12;90 12 12;120 12 12;150 12 12;180 12 12;210 12 12;240 12 12;270 12 12;300 12 12;330 12 12;360 12 12"/>
        </g>
    </svg>
</div>

{{--<div id="preloader">--}}
{{--    <div class="spinner-border color-highlight" role="status"></div>--}}
{{--</div>--}}


<div id="page" class="mx-2 mx-sm-3 mx-md-4 mx-lg-5">
    @include('frontend.components.header')
    @include('frontend.components.footer')
    @include('frontend.components.sidebar')
    @include('frontend.components.admin_sidebar')
    @include('frontend.components.colors')
    @include('frontend.components.notifications')
    @include('frontend.components.search')
    @include('frontend.components.categories')
    @include('frontend.components.cart')


    {{--    Modals   --}}
    @include('frontend.components.modals.auth.register_modal')
    @include('frontend.components.modals.auth.login_modal')
    @include('frontend.components.modals.auth.forgot_modal')
    @include('frontend.components.modals.terms_modal')


    <div class="page-content header-clear-medium mx-2 mx-sm-3 mx-md-4 mx-lg-5">
{{--        PAGE BACKGROUND !!  --}}
{{--        <div class="card bg-333 mb-n5 position-fixed start-0 end-0 bottom-0 top-0" data-card-height="cover" style="height: 959px;">  --}}
{{--            <div class="card-overlay bg-gradient opacity-90"></div>  --}}
{{--        </div> --}}
        @if($errors->any())
            <div class="text-center alert bg-fade-red color-red-dark alert-dismissible rounded-s fade show"
                 role="alert">
                @foreach($errors->all() as $error)
                    <i class="bi bi-exclamation-triangle pe-2"></i>
                    <strong>Warning</strong> - {{$error}}
                    <button type="button" class="btn-close opacity-20 font-11 pt-3 mt-1" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    <br>
                @endforeach
            </div>
        @endif
        @yield('index')
        @yield('product-single')
        @yield('cart')
        @yield('front-categories')
        @yield('front-category-single')
        @yield('login')
        @yield('faqs')

        @yield('admin-products-all')
        @yield('admin-categories-all')
        @yield('admin-discounts')
        @yield('admin-terms')
        @yield('admin-faqs')

        <div class="card card-style py-3">
            <div class="content px-2 text-center">
                <p class="mb-3">
                    Created by
                </p>
                <a href="https://1.envato.market/2ryjKA" target="_blank"
                   class="default-link btn btn-m rounded-s gradient-highlight shadow-bg shadow-bg-s px-5 mb-0 mt-2">
                    Get Duo Now
                </a>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-bottom rounded-m offcanvas-detached" id="menu-install-pwa-ios">
        <div class="content">
            <img src="{{asset('defaults/default_placeholder.png')}}" alt="img" width="80" class="rounded-l mx-auto my-4">
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
            <img src="{{asset('defaults/default_placeholder.png')}}" alt="img" width="80" class="rounded-m mx-auto my-4">
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


<div id="cart_toast" class="toast toast-bar toast-top rounded-l bg-green-dark shadow-bg shadow-bg-s fade hide"
     data-bs-delay="3000">
    <div class="align-self-center">
        <i class="icon icon-s bg-green-light rounded-l bi bi-check font-28 me-2"></i>
    </div>
    <div class="align-self-center ps-1">
        <strong class="font-13 mb-n2">Logged In</strong>
        <span class="font-10 mt-n1 opacity-70">Welcome back, John!</span>
    </div>
    <div class="align-self-center ms-auto">
        <button type="button" class="btn-close btn-close-white me-2 m-auto font-9" data-bs-dismiss="toast"></button>
    </div>
</div>


{{--fix scroll position--}}
<script>
    window.addEventListener('beforeunload', function () {
        localStorage.setItem('scrollPosition', window.scrollY);
    });

    window.addEventListener('load', function () {
        if (localStorage.getItem('scrollPosition') !== null) {
            window.scrollTo(0, parseInt(localStorage.getItem('scrollPosition'), 10));
            localStorage.removeItem('scrollPosition'); // Clear the stored position after use
        }
    });

</script>

<script src="{{asset('frontassets/scripts/bootstrap.min.js')}}"></script>
<script src="{{asset('frontassets/scripts/custom.js')}}"></script>
<script src="{{asset('frontassets/customjs/imageupload.js')}}"></script>
<script src="{{asset('frontassets/custom-htmx.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/htmx.org@2.0.7/dist/htmx.min.js"
        integrity="sha384-ZBXiYtYQ6hJ2Y0ZNoYuI+Nq5MqWBr+chMrS/RkXpNzQCApHEhOt2aY8EJgqwHLkJ"
        crossorigin="anonymous"></script>

@stack('js')

{{--card height--}}
<script>
    function updateCardHeight() {
        const card = document.querySelectorAll('.custom-card');
        let newHeight;

        if (window.innerWidth < 576) {
            // Mobile
            newHeight = 140;
        } else if (window.innerWidth < 992) {
            // Tablet
            newHeight = 200;
        } else {
            // Desktop
            newHeight = 400;
        }

        // Update attribute and CSS height
        card.forEach((card) => {
            card.setAttribute('data-card-height', newHeight);
            card.style.height = newHeight + 'px';
        })

    }

    // Run on load & resize
    window.addEventListener('resize', updateCardHeight);
    updateCardHeight();
</script>
{{--overlay--}}
<script>
    function showOverlay() {
        document.getElementById('overlay').style.display = 'flex';
    }
</script>


@if(session()->has('alert_error'))
    <script>
        window.alertError = @json(session()->get('alert_error'));
    </script>
@endif

@if(session()->has('alert_success'))
    <script>
        window.alertSuccess = @json(session()->get('alert_success'));
    </script>
@endif

@if ($errors->any())
    <script>
        window.validationErrors = @json($errors->all());
    </script>
@endif

{{--cart functionality--}}
<script>
    // const cart_icon_number = document.getElementById('cart_icon_number')

    {{--const Cart = {--}}
    {{--    token: '{{request()->cookie('cart_token')}}',--}}

    {{--    getQuantity() {--}}
    {{--        return parseInt(localStorage.getItem(this.token)) || 0;--}}
    {{--    },--}}

    {{--    setQuantity(qty) {--}}
    {{--        const quantity = Math.max(0, parseInt(qty) || 0);--}}
    {{--        if (quantity === 0) {--}}
    {{--            localStorage.removeItem(this.token);--}}
    {{--        } else {--}}
    {{--            localStorage.setItem(this.token, quantity);--}}
    {{--        }--}}
    {{--        return quantity;--}}
    {{--    },--}}

    {{--    add(amount = 1) {--}}
    {{--        const newQty = this.getQuantity() + amount;--}}
    {{--        return this.setQuantity(newQty);--}}
    {{--    },--}}

    {{--    remove(amount = 1) {--}}
    {{--        const currentQty = this.getQuantity();--}}
    {{--        // Only remove if current quantity is greater than 0--}}
    {{--        if (currentQty > 0) {--}}
    {{--            const newQty = currentQty - amount;--}}
    {{--            return this.setQuantity(newQty);--}}
    {{--        }--}}
    {{--        return currentQty; // Return current quantity (0) if already at minimum--}}
    {{--    },--}}

    {{--    clear() {--}}
    {{--        localStorage.removeItem(this.token);--}}
    {{--        cart_icon_number.style.display = 'none'--}}
    {{--        return 0;--}}
    {{--    }--}}
    {{--};--}}


    {{--if (Cart.getQuantity() > 0) {--}}
    {{--    cart_icon_number.style.display = 'inline-block'--}}
    {{--    cart_icon_number.innerText = Cart.getQuantity()--}}
    {{--}--}}

    {{--// Usage--}}
    {{--function addToCart() {--}}
    {{--    Cart.add()--}}
    {{--    cart_icon_number.style.display = 'inline-block'--}}
    {{--    cart_icon_number.innerText = Cart.getQuantity()--}}
    {{--}--}}

    {{--function removeFromCart() {--}}
    {{--    Cart.remove();--}}
    {{--    cart_icon_number.innerText = Cart.getQuantity()--}}
    {{--}--}}

</script>

</body>

