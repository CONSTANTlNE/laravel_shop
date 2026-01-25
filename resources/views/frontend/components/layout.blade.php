<!DOCTYPE HTML>
<html lang="{{app()->getLocale()}}">
<head>
    <meta http-equiv="Content-Type" content="text/html;"/>
    <meta charset="utf-8">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, viewport-fit=cover">
    <link rel="shortcut icon" href="{{asset('shopz_man2.jpeg')}}">
    <meta name="robots" content="index, follow">

    <meta name="author" content="shopz.ge">
    <meta name="application-name" content="shopz.ge">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600;700;800&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">
    {{--    <link rel="manifest" href="_manifest.json">--}}
    <meta id="theme-check" name="theme-color" content="#FFFFFF">
    <meta name="htmx-config" content='{"selfRequestsOnly":false}'>
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('shopz_man2.jpeg')}}">

    <meta property="og:site_name" content="shopz.ge">
    <meta property="og:locale" content="{{app()->getLocale()}}">
    <meta property="og:type" content="website">

    @yield('index-meta')
    @yield('categories-meta')
    @yield('product-meta')
    @yield('index-categories')
    @vite([ 'resources/js/app.js'])
    <link rel="stylesheet" href="{{asset('frontassets/styles/custom.css')}}">
    @stack('css')
    @stack('json-ld')
</head>

<body class=" {{$site_settings->dark_theme ? 'theme-dark' : 'theme-light' }}" data-highlight="{{$active_color->color}}">
<script>
    localStorage.setItem('shopz.ge' + '-Highlight', '{{$active_color->color}}')

</script>
<div class="overlay" id="overlay" style="display:none;">

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
    @if(!request()->routeIs('password.reset'))
        @include('frontend.components.admin_sidebar')
    @endif
    @include('frontend.components.colors')
    @include('frontend.components.notifications')
    @include('frontend.components.search')
    @include('frontend.components.categories')
    @include('frontend.components.cart')
    @auth('web')
        @include('frontend.customer.profile_modal')
    @endauth
    @include('frontend.auth.register_modal')
    @include('frontend.auth.login_modal')
    @include('frontend.auth.forgot_modal')
    @include('frontend.components.modals.terms_modal')



    {{--  backend  Modals   --}}
    @if(!request()->routeIs('password.reset'))
        @include('backend.components.modals.admin_settings')
    @endif
    {{--@dd($site_settings)--}}

    <div class="page-content header-clear-medium mx-2 mx-sm-3 mx-md-4 mx-lg-5" id="layout_target">
        {{--        PAGE BACKGROUND !!  --}}
        {{--        <div class="card bg-333 mb-n5 position-fixed start-0 end-0 bottom-0 top-0" data-card-height="cover" style="height: 959px;">  --}}
        {{--            <div class="card-overlay bg-gradient opacity-90"></div>  --}}
        {{--        </div> --}}

        {{--  Banners   --}}
        {{--        &&  !auth('admin')->check()--}}
        @if($site_settings->use_main_banner && !request()->routeIs('checkout') && !request()->routeIs('product.single') && !request()->routeIs('customer.orders'))
            <div class="splide single-slider slider-no-dots slider-no-arrows slider-boxed text-center mt-n2"
                 id="banner-slider">
                <div class="splide__track">
                    <div class="splide__list">
                        @if(isset($banners) && $banners->isNotEmpty())
                            @foreach($banners as $banner)
                                <div class="splide__slide">
                                    <div class="card card-style mx-0 shadow-card shadow-card-m bg-14"
                                         style="background-image: url({{$banner->getFirstMediaUrl('banner_image')}})"
                                         data-card-height="400">
                                        <div class="card-bottom pb-3 px-3">
                                            <h3 class="color-white mb-1">{{$banner->header}} </h3>
                                            <p class="color-white opacity-80 mb-0 mt-n1 font-14">{{$banner->description}}</p>
                                        </div>
                                        {{--                                        <div class="card-overlay bg-gradient-fade"></div>--}}
                                    </div>
                                </div>
                            @endforeach
                        @else
                            {{--                            <div class="splide__slide">--}}
                            {{--                                <div class="card card-style mx-0 shadow-card shadow-card-m bg-14"--}}
                            {{--                                     data-card-height="400">--}}
                            {{--                                    <div class="card-bottom pb-3 px-3">--}}
                            {{--                                        <h3 class="color-white mb-1">Meet Duo 3.0</h3>--}}
                            {{--                                        <p class="color-white opacity-80 mb-0 mt-n1 font-14">Duo is now Better than--}}
                            {{--                                            Ever!</p>--}}
                            {{--                                    </div>--}}
                            {{--                                    <div class="card-overlay bg-gradient-fade"></div>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                        @endif
                    </div>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="d-flex justify-content-center">
                <div style="max-width: 500px"
                     class="text-center alert bg-fade-red color-red-dark alert-dismissible rounded-s fade show"
                     role="alert">
                    @foreach($errors->all() as $error)
                        <i class="bi bi-exclamation-triangle pe-2"></i>
                        <strong>Warning</strong> - {{$error}}
                        <button type="button" class="btn-close opacity-20 font-11 pt-3 mt-1" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        <br>
                    @endforeach
                </div>
            </div>
        @endif
        @if(session()->has('success'))
            <div class="d-flex justify-content-center">
                <div style="max-width: 400px"
                     class="alert bg-green-light shadow-bg shadow-bg-m alert-dismissible rounded-s fade show mb-3 text-center"
                     role="alert">
                    <i class="bi bi-check-circle-fill pe-2"></i>
                    {{--                    <strong>Awesome</strong> - --}}
                    {{session('success')}}
                    <button type="button" class="btn-close opacity-10" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                </div>
            </div>
        @endif
        @if(session()->has('status'))
            <div class="d-flex justify-content-center">
                <div style="max-width: 400px"
                     class="alert bg-green-light shadow-bg shadow-bg-m alert-dismissible rounded-s fade show mb-3 text-center"
                     role="alert">
                    <i class="bi bi-check-circle-fill pe-2"></i>
                    {{--                    <strong>Awesome</strong> - --}}
                    {{session('status')}}
                    <button type="button" class="btn-close opacity-10" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                </div>
            </div>
        @endif


        @yield('index')
        @yield('product-single')
        @yield('cart')
        @yield('front-categories')
        @yield('front-category-single')
        @yield('front-discounted-products')
        @yield('login')
        @yield('faqs')
        @yield('checkout')
        @yield('customer-orders')
        @yield('customer-dashboard')
        @yield('password-reset')

        @yield('admin-products-all')
        @yield('admin-categories-all')
        @yield('admin-discounts')
        @yield('admin-banners')
        @yield('admin-coupons')
        @yield('admin-terms')
        @yield('admin-faqs')
        @yield('admin-orders')
        @yield('admin-shipping-prices')
        @yield('admin-users')
        @yield('admin-admins')
        @yield('admin-excel')

        @if(request()->routeIs('customer.dashboard'))
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
        @endif
    </div>


{{--@include('frontend.components.custom_chat_chatwootAPI')--}}


    <div class="offcanvas offcanvas-bottom rounded-m offcanvas-detached" id="menu-install-pwa-ios">
        <div class="content">
            <img src="{{asset('defaults/default_placeholder.png')}}" alt="img" width="80"
                 class="rounded-l mx-auto my-4">
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
            <img src="{{asset('defaults/default_placeholder.png')}}" alt="img" width="80"
                 class="rounded-m mx-auto my-4">
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


@include('frontend.components.toasts.cart_toast')
@include('frontend.components.toasts.general_success_toast')


<script src="{{asset('frontassets/scripts/custom.js')}}"></script>
<script src="{{asset('frontassets/scripts/bootstrap.min.js')}}"></script>

<script src="{{asset('frontassets/customjs/imageupload.js')}}"></script>
<script src="{{asset('frontassets/custom-htmx.js')}}"></script>



@stack('js')

{{-- chatwoot api channel--}}
{{--<script src="{{asset('frontassets/chatwoot.js')}}" ></script>--}}
{{--card height--}}
<script>
    function innerCopy(element) {
        navigator.clipboard.writeText(element.innerHTML);
    }

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

<script>
    // remove cart item if qty is 0 via htmx
    document.body.addEventListener('remove_cart_item', (event) => {
        const id = event.detail.id;
        const removable = document.getElementById(`removable${id}`)
        // wait until the swap cycle finishes for HTMX
        requestAnimationFrame(() => {  // or setTimeout(..., 0)
            removable?.remove();
        });
    });
</script>

<script>
     // remove item from cart afterrequest htmx
    function handleRemoval(id) {

        document.getElementById('removable' + id).remove();
    }

    //  =======  avoid double click on submit buttons .. not for htmx !!

    // document.querySelector('form').addEventListener('submit', function(e) {
    //     const submitBtn = this.querySelector('button[type="submit"]');
    //     submitBtn.disabled = true;
    //     submitBtn.textContent = 'Processing...';
    // });


    // document.addEventListener('click', (e) => {
    //     if (e.target.matches('.action-button')) {
    //         const button = e.target;
    //
    //         // Prevent multiple spinners
    //         if (!button.querySelector('.spinner-border')) {
    //             const spinner = document.createElement('span');
    //             spinner.className = 'spinner-border spinner-border-sm ms-2';
    //             spinner.role = 'status';
    //             spinner.innerHTML = '<span class="visually-hidden">Loading...</span>';
    //             button.appendChild(spinner);
    //         }
    //
    //         // Delay disabling the button slightly to allow form submission
    //         setTimeout(() => {
    //             button.type = button;
    //         }, 10); // 10ms delay is enough
    //     }
    // });

    function spinner(button) {

        // Prevent multiple spinners
        if (!button.querySelector('.spinner-border')) {
            const spinner = document.createElement('span');
            spinner.className = 'spinner-border spinner-border-sm ms-2';
            spinner.role = 'status';
            spinner.innerHTML = '<span class="visually-hidden">Loading...</span>';
            button.appendChild(spinner);
        }

        // Delay disabling the button slightly to allow form submission
        setTimeout(() => {
            button.type = button;
        }, 10); // 10ms delay is enough

    }

    @if(request()->routeIs('home'))
    new Splide('#banner-slider').mount();
    @endif





    // document.body.addEventListener('htmx:afterRequest', function(event) {
    //     const target = event.target;
    //
    //     // If the element has our custom attribute, refresh the page
    //     if (target && target.dataset.refreshPage !== undefined) {
    //         window.location.reload();
    //     }
    // });


</script>


<script>

    document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'hidden') {
            console.log('User left the tab');
        }

        if (document.visibilityState === 'visible') {
            console.log('User returned to the tab');
        }
    });


    // const REFRESH_AFTER = 1 * 60 * 1000; // 5 minutes
    // let hiddenAt = null;
    //
    // document.addEventListener('visibilitychange', () => {
    //     if (document.visibilityState === 'hidden') {
    //         hiddenAt = Date.now();
    //     }
    //
    //     if (document.visibilityState === 'visible' && hiddenAt) {
    //         const awayTime = Date.now() - hiddenAt;
    //
    //         if (awayTime >= REFRESH_AFTER) {
    //             // location.reload();
    //             alert('Session Has Expired Please login')
    //         }
    //         hiddenAt = null;
    //     }
    // });


    // let wakeLock = null;
    //
    // async function requestWakeLock() {
    //     try {
    //         wakeLock = await navigator.wakeLock.request('screen');
    //         console.log('Wake Lock active');
    //     } catch (err) {
    //         console.error('Wake Lock failed:', err);
    //     }
    // }

</script>


</body>

