<!DOCTYPE HTML>
<html lang="{{app()->getLocale()}}" hx-headers='{"X-CSRF-TOKEN": "{{csrf_token()}}"}'>
<head>
    <meta http-equiv="Content-Type" content="text/html;"/>
    <meta charset="utf-8">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, viewport-fit=cover">
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
    <style>
        .myloader {
            font-weight: bold;
            font-family: sans-serif;
            font-size: 30px;
            animation: l1 1s linear infinite alternate;
        }

        .myloader:before {
            content: "Loading..."
        }

        @keyframes l1 {
            to {
                opacity: 0
            }
        }

        .htmx-indicator {
            opacity: 0;
            margin-top: 0;
            margin-bottom: 0;
            height: 0;
            visibility: hidden;
            font-weight: bold;
            font-family: sans-serif;
            font-size: 30px;
            animation: l1 1s linear infinite alternate;
        }

        .htmx-indicator:before {
            content: "Loading..."
        }

        @keyframes l1 {
            to {
                opacity: 0
            }
        }

        .htmx-request .htmx-indicator {
            display: inline;

        }

        .htmx-request.htmx-indicator {
            opacity: 1;
            margin-top: 10px;
            height: 30px;
            margin-bottom: 10px;
            visibility: visible;
            transition: opacity 200ms ease-in;
        }

        .product-image-wrapper {
            width: 100%;
            aspect-ratio: 1 / 1; /* Makes the image a perfect square */
            background-size: cover;
            background-position: center;
            border-radius: 10px; /* Optional: matches modern card styles */
            height: auto !important; /* Overrides any inherited fixed heights */
        }

        /* Optional: Limit the size only on desktop so it doesn't get TOO big */
        @media (min-width: 1200px) {
            .featured_anchor {
                display: block;
                max-width: 450px;
            }
        }

        @media (max-width: 480px) {

            .featured_anchor {
                display: block;
                width: 150px !important; /* Keeps your specific height design */

            }
        }

        .offcanvas-modal {
            -webkit-overflow-scrolling: touch;
            max-height: 700px;
        }

    </style>
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
            @include('frontend.components.main_banner')
        @endif

        @include('frontend.components.session_messages')

{{--        @if($export!=null)--}}
{{--            <div class="d-flex justify-content-center mb-3">--}}
{{--                <div hx-get="{{route('exports.message')}}"--}}
{{--                     id="export_status"--}}
{{--                     hx-trigger="load delay:2s"--}}
{{--                     hx-swap="outerHTML">--}}
{{--                    @if($export!=null)--}}
{{--                        Ready--}}
{{--                        <a href="{{ route('exports.download') }}" target="_blank">--}}
{{--                            Download Export--}}
{{--                        </a>--}}
{{--                    @else--}}
{{--                        Preparing download--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @endif--}}

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
        @yield('admin-carts')
        @yield('admin-shipping-prices')
        @yield('admin-users')
        @yield('admin-admins')
        @yield('admin-excel')
        @yield('site-data')

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


{{--<script src="{{asset('frontassets/scripts/custom.js')}}"></script>--}}
<script src="{{asset('frontassets/customjs/imageupload.js')}}"></script>
<script src="{{asset('frontassets/custom-htmx.js')}}"></script>


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

<script id="htmx_messages"></script>

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

    @if($site_settings->use_main_banner && !request()->routeIs('checkout') && !request()->routeIs('product.single') && !request()->routeIs('customer.orders'))
       document.addEventListener('DOMContentLoaded', function () {
        new Splide('#banner-slider', {
            arrows: false,
            lazyLoad: 'nearby',
            autoplay: true,
            interval: 3000,
            type: 'loop',
            loop: true,
        }).mount();
    });
    @endif

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

    document.addEventListener('DOMContentLoaded', () => {

        const footer_bar=document.getElementById('footer-bar');
// 1. Select all offcanvas elements (not the triggers, the actual menus)
        const myOffcanvasElements = document.querySelectorAll('.offcanvas');

        myOffcanvasElements.forEach(offcanvas => {

            // Triggered immediately when 'show' is called
            offcanvas.addEventListener('show.bs.offcanvas', () => {
                console.log('Offcanvas is starting to open...');
            });

            // Triggered when it is fully visible (after CSS transitions)
            offcanvas.addEventListener('shown.bs.offcanvas', () => {
                footer_bar.style.display = 'none';
            });

            // Triggered immediately when 'hide' is called
            offcanvas.addEventListener('hide.bs.offcanvas', () => {
                console.log('Offcanvas is starting to close...');
            });

            // Triggered when it is fully hidden
            offcanvas.addEventListener('hidden.bs.offcanvas', () => {
                footer_bar.style.display = 'flex';
            });
        });
    })

    {{-- onSubmit(this.form,this,'{{__('Please Wait')}}') --}}
    function onSubmit(form, button , text) {
        form.onsubmit = function() {
            button.disabled = true;

            // Define your SVG (a simple loading spinner)
            const spinnerSvg = `
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><circle cx="4" cy="12" r="3" fill="currentColor"><animate id="SVG9IgbRbsl" attributeName="r" begin="0;SVGFUNpCWdG.end-0.25s" dur="0.75s" values="3;.2;3"/></circle><circle cx="12" cy="12" r="3" fill="currentColor"><animate attributeName="r" begin="SVG9IgbRbsl.end-0.6s" dur="0.75s" values="3;.2;3"/></circle><circle cx="20" cy="12" r="3" fill="currentColor"><animate id="SVGFUNpCWdG" attributeName="r" begin="SVG9IgbRbsl.end-0.45s" dur="0.75s" values="3;.2;3"/></circle></svg>
`;

            // Use innerHTML to combine text and SVG
            button.innerHTML = text + spinnerSvg;
        };
    }

    // Initialize Notyf
    let notyf;
    document.addEventListener('DOMContentLoaded', () => {
        notyf = new Notyf({
            duration: 3000,
            position: {x: 'center', y: 'top'},
            dismissible: true,
            types: [
                {
                    type: 'success',
                    background: '#28a745', // You can change this to match your brand
                },
                {
                    type: 'error',
                    background: '#dc3545',
                }
            ]
        });
    })

    // show success message via HTMX and notif
    document.body.addEventListener('showSuccess', function (evt) {

        notyf.open({
            type: evt.detail.icon || 'success',
            message: evt.detail.message
        });
    });

    // show error message via HTMX and notif
    document.body.addEventListener('showError', function (evt) {
        Swal.fire({
            icon: evt.detail.icon,
            text: evt.detail.message,
            showConfirmButton: false,
            timer: 2800
        });
    });

    // show validation errors via HTMX and swal
    document.body.addEventListener('htmx:beforeOnLoad', function (evt) {
        if (evt.detail.xhr.status === 422) {
            // Prevent HTMX from trying to swap the error response into the DOM
            evt.detail.shouldSwap = false;

            const response = JSON.parse(evt.detail.xhr.responseText);
            const errors = response.errors;

            // Convert the error object into a readable list
            let errorHtml = '<ul style="text-align: left;">';
            Object.values(errors).forEach(errorMessages => {
                errorMessages.forEach(message => {
                    errorHtml += `<li>${message}</li>`;
                });
            });
            errorHtml += '</ul>';

            Swal.fire({
                icon: 'error',
                title: 'Validation Failed',
                html: errorHtml,
                showConfirmButton: true
            });
        }
    });

</script>
@stack('js')

</body>

