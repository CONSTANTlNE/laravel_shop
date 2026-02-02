@extends('frontend.components.layout')

@section('product-meta')
    <title>{{$product->name}} | shopz.ge</title>
    <link rel="canonical" href="{{url()->current()}}">
    <meta name="description" content="შეიძინე ონლაინ "{{$product->name}} ">
    <meta property="og:title" content="{{$product->name}} - {{$product->price}}">
    <meta property="og:description" content="შეიძინე ონლაინ "{{$product->name}} >
    <meta property="og:type" content="product">
    <meta property="og:image" content="{{$product->media->where('main',1)->first()?->getUrl('thumbnail')}}">
    <meta property="og:url" content="{{url()->current()}}">
@endsection

@push('json-ld')
    <script type="application/ld+json">
        {
          "@@context": "https://schema.org/",
          "@type": "Product",
          "name": "{{$product->name}}",
          "image": [
    "{{ $product->getFirstMediaUrl('product_image') }}" {{-- Use the actual image URL, not url()->current() --}}
        ],
        "description": "{{ strip_tags($product->description) }}",
        "sku": "{{$product->sku}}",
        {{--  "gtin13": "{{$product->gtin}}", --}}{{-- CRITICAL: Adds your product to the Google Shopping Graph --}}
        "brand": {
          "@type": "Brand",
          "name": "shopz.ge"
       },

        {{--  "aggregateRating": { --}}{{-- Shows the gold stars in search results --}}
        {{--        "@type": "AggregateRating",--}}
        {{--        "ratingValue": "{{$product->average_rating}}",--}}
        {{--    "reviewCount": "{{$product->reviews_count}}"--}}
        {{--  },--}}
        "offers": {
          "@type": "Offer",
          "url": "{{ url()->current() }}",
    "priceCurrency": "GEL",
    "price": "{{$product->price}}",
    "priceValidUntil": "{{ now()->addYear()->format('Y-m-d') }}",
    "itemCondition": "https://schema.org/NewCondition",
    "availability": "https://schema.org/InStock",
    "shippingDetails": { {{-- NEW for 2026: Shows 'Free Shipping' or 'Express' in snippets --}}
        "@type": "OfferShippingDetails",
        "shippingRate": {
          "@type": "MonetaryAmount",
          "value": "0",
          "currency": "GEL"
        },
        "shippingDestination": {
          "@type": "DefinedRegion",
          "addressCountry": "GE"
        }
      },
      "hasMerchantReturnPolicy": { {{-- Boosts buyer confidence directly in Google Search --}}
        "@type": "MerchantReturnPolicy",
        "applicableCountry": "GE",
        "returnPolicyCategory": "https://schema.org/MerchantReturnFiniteReturnPeriod",
        "merchantReturnDays": 14,
        "returnMethod": "https://schema.org/ReturnByMail"
      }
    }
  }
    </script>
@endpush

@section('product-single')
    @push('css')
        <style>
            .descr_div p {
                margin-bottom: 5px;
            }
        </style>
        @if(auth('admin')->check())
            <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet"/>
        @endif
    @endpush

    {{--    <div style="margin-left: 0;margin-right: 0; --}}
    {{--         @if($main_image) --}}
    {{--            background-image: url({{$main_image->getUrl()}}) --}}
    {{--        @elseif($product->getMedia('product_image')->first()) --}}
    {{--            background-image: url({{asset($product->getMedia('product_image')->first()->getUrl())}}) --}}
    {{--        @endif" --}}
    {{--         class="card card-style preload-img product_card_height"> --}}
    {{--        <div class="card-overlay bg-gradient"></div> --}}
    {{--    </div> --}}
    {{--    @dd($product->getMedia('product_image')->first()->getUrl()) --}}

    {{--  big slider  --}}
    <div id="main-slider" class='splide card card-style  mb-3' style="max-height: 1500px">
        <div class="splide__track">
            <ul class="splide__list  w-100">
                @if($product->getMedia('product_image')->isNotEmpty())
                    @foreach($product->getMedia('product_image') as $media)
                        <li class="splide__slide preload-img product_card_height w-100" style="min-height: 300px">
                            <a class="col mb-4" data-gallery="gallery-1"
                               href="{{ $media->getUrl() }}"
                               title="{{ $product->name }}">
                                <img src="{{asset($media->getUrl())}}" alt="product image {{$product->name}}"
                                     style="object-fit: contain; object-position: center;"
                                     class=" h-100 w-100">
                            </a>
                        </li>
                    @endforeach
                @else
                    <li class="splide__slide preload-img product_card_height w-100" style="min-height: 300px">
                        <a class="col mb-4" data-gallery="gallery-1"
                           href="{{ asset('defaults/default_placeholder.png')}}}}"
                           title="{{ $product->name }}">
                            <img src="{{asset('defaults/default_placeholder.png')}}" alt="" class="w-100">
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    {{--     thumbnail slider --}}
    <div class="d-flex justify-content-center">
        <div id="thumbnail-slider" class='splide mb-3' style="max-width: 500px">
            <div class="splide__track">
                <ul class="splide__list  w-100">
                    @if($product->getMedia('product_image')->isNotEmpty())
                        @foreach($product->getMedia('product_image') as $media2)
                            <li class="splide__slide">
                                <img src="{{$media2->getUrl('thumbnail')}}" alt="" class="w-100 img-fluid">
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
    {{--     add images  --}}
    @if(auth('admin')->check() && auth('admin')->user()->hasAnyRole('admin|developer'))
        @include('backend.components.modals.product_add_images_modal')
    @endif
    {{--  page main content--}}
    <div style="margin-left: 0;margin-right: 0" class="card card-style">
        <div class="content">
            <div class="d-flex  justify-content-between align-items-center mb-2">
                <div class="d-flex flex-wrap justify-content-center align-items-center gap-2 mb-1">
                    <div class="d-flex flex-column">
                        <h1 class="product-name-single">{{$product->name}}</h1>
                        @if($site_settings->use_sku)
                            <div class="d-flex gap-3 mt-1">
                                <h4>{{__('SKU')}}:</h4>
                                <span style="cursor:pointer" onclick="innerCopy(this)">{{$product->sku}}</span>
                            </div>
                        @endif
                    </div>
                    @if(auth('admin')->check())
                        @include('frontend.product-single.components.product_name_edit_modal')
                    @endif
                </div>
            </div>
            {{--    description edit modal --}}
            @if(auth('admin')->check())
                @include('frontend.product-single.components.description_edit_modal')
            @endif
            {{--    product description --}}
            <div class="descr_div">
                {!! $product->description !!}
            </div>
            {{--    product features if available --}}
            <div id="features_form" class="row mb-0 mt-2">
                @foreach($product->features as $feature_index => $feature)
                    <div class="col-4">
                        <div class="d-flex gap-1">
                            <span class="font-11">{{$feature->feature_name}}</span>
                            {{--   feature edit and delete modal--}}
                            @if(auth('admin')->check())
                                @include('frontend.product-single.components.feature_edit_delete_modals')
                            @endif
                        </div>
                        <p class="mt-n2 mb-3">
                            <strong class="color-theme">{{$feature->feature_text}}</strong>
                        </p>
                    </div>
                @endforeach
                {{--  add product features --}}
                @if(auth('admin')->check())
                    @include('frontend.product-single.components.feature_add_modal')
                @endif
            </div>
            <div class="divider mt-3"></div>
            {{--  if present is appllicable on product show present --}}
            @if($product->presents->isNotEmpty())
                <div class="d-flex gap-2 flex-wrap justify-content-center mt-1 mb-2">
                    <div class="content mb-0">
                        <h3 class=" text-center">{{__('Present2')}}</h3>
                        <div class="d-flex justify-content-center gap-3">
                            @foreach($product->presents as $present)
                                <a href="{{route('product.single',['locale'=>app()->getLocale(),'product'=>$present->slug])}}">
                                    <div class="d-flex mb-3">
                                        <div class="align-self-center me-auto">
                                            {{--   <h4 class="font-500 font-15 pb-1">{{$product->presents()->first()->name}}</h4> --}}
                                            {{--   <span class="badge text-uppercase px-2 py-1 gradient-green shadow-bg shadow-bg-s">Web Design</span>--}}
                                            {{--   <span class="color-theme font-10 ps-2 opacity-50">25 Minutes Ago</span>--}}
                                        </div>
                                        <div class="align-self-start ms-auto">
                                            <h4 class="font-500 font-15 ">{{$present->name}}</h4>
                                            <img src="{{$present->getFirstMedia('product_image')->getUrl('thumbnail')}}"
                                                class="rounded-m " height="130">
                                        </div>
                                    </div>
                                </a>

                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="divider mt-3"></div>
            @endif
            {{-- present products  --}}
            @if($product->is_present==true)
                <div class="d-flex flex-column justify-content-center align-items-center mb-3">
                    <p class="text-center mb-1 font-13">{{__('Receive this product as gift when buying :')}}</p>
                    @foreach($product->presentToProducts as $haspresent)
                        <a href="">{{$haspresent->name}}</a>
                    @endforeach
                </div>
            @endif
            {{--    product price and edit --}}
            @if($product->for_sale==true)
                <div class="d-flex justify-content-center align-items-center gap-2">
                    <div class="d-flex justify-content-center gap-2">
                        <h5 class=" font-20">{{$product->price}}
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 16" width="12"
                                 height="14"
                                 class="md:w-1-4 w-2-0 text-black-600 mb-1">
                                <path fill="currentColor" fill-rule="evenodd"
                                      d="M14 8.094c-.017.013-.034.024-.05.039-.33.322-.662.644-.992.968-.015.014-.023.036-.034.055l-.028-.013c-.014-1.18-.352-2.26-1.044-3.233-.693-.974-1.614-1.66-2.751-2.096v.084l.001 4.045c0 .049-.014.082-.05.116L7.966 9.11l-.058.053V3.513c-.137-.015-.268-.038-.4-.043-.233-.01-.468-.017-.702-.011-.197.004-.394.03-.592.042-.047.004-.04.031-.04.06l-.002 1.246c0 1.045-.002 2.09-.001 3.136 0 .048-.014.082-.05.116L5.036 9.11l-.05.045V3.811l-.19.073c-.305.124-.601.265-.878.44-.362.229-.7.484-1.007.782-.312.303-.584.634-.82.995-.296.45-.515.934-.672 1.447-.106.345-.175.696-.206 1.053-.036.423-.042.847.016 1.272.065.48.185.944.37 1.392.17.409.379.798.649 1.153.154.202.319.398.49.587.277.308.596.57.94.805.358.243.738.449 1.14.616.385.16.789.258 1.2.336.354.067.71.082 1.07.082 1.91-.002 3.822 0 5.733 0h.094l-.054.055-1.106 1.08c-.007.006-.012.014-.018.021H.007c.013-.018.024-.039.04-.054.361-.353.724-.705 1.085-1.059.032-.032.065-.043.11-.043h1.861c-.201-.151-.402-.287-.584-.444-.249-.215-.494-.436-.72-.673-.254-.266-.477-.556-.679-.862-.201-.306-.379-.624-.528-.955-.308-.68-.498-1.39-.564-2.132-.039-.44-.038-.88.005-1.319.035-.356.107-.705.196-1.05.092-.361.216-.712.38-1.049.08-.163.152-.33.242-.487.105-.183.216-.365.34-.535.18-.247.363-.493.566-.721.275-.31.585-.587.916-.841.679-.522 1.425-.916 2.25-1.165.046-.014.062-.032.061-.08-.004-.41-.002-.82-.01-1.229-.002-.105.015-.188.111-.245.02-.012.035-.032.052-.048l.975-.953.06-.056v2.343c.58-.07 1.155-.076 1.734.002V2.27l-.001-1.05c0-.046.013-.078.047-.11.366-.352.73-.705 1.095-1.058l.054-.048V.08l.001 1.125v1.333c0 .04.012.056.054.07.198.066.398.13.59.208.612.25 1.176.578 1.695.98.302.234.58.494.839.77.285.304.536.635.756.987.265.424.494.865.652 1.337.092.278.166.562.244.844.029.103.046.21.068.315v.046z"></path>
                            </svg>
                        </h5>
                        @if($product->price_before_discount && $site_settings->show_discounted==1)
                            <del class="opacity-50 font- mt-n1">
                                {{$product->price_before_discount }}₾
                            </del>
                        @endif
                    </div>
                    {{--  edit price modal --}}
                    @if(auth('admin')->check())
                        <div class="flex">
                            @include('frontend.product-single.components.product_edit_price_modal')
                        </div>
                    @endif
                </div>
            @endif
            {{--  purchase and share buttons , not for sale comment and present available products --}}
            <div class="d-flex flex-wrap justify-content-center pt-2 gap-3 mb-5">
                <div class="d-flex gap-2">
                    <div class="w-100 d-flex justify-content-center align-items-center gap-2 ms-auto">
                        {{--  pruchase button --}}
                        @if($product->for_sale==true)
                            @if($in_cart)
                                <button
                                    id="add_to_cart_single"
                                    hx-swap-oob="true"
                                    hx-post="{{route('cart.add.single')}}"
                                    hx-target="#cart_icon_number"
                                    hx-vals='{"_token":"{{csrf_token()}}","product_id":"{{$product->id}}"}'
                                    class="btn-full btn gradient-green shadow-bg shadow-bg-m ">
                                    {{__('Added to cart')}}
                                </button>
                            @else
                                <button
                                    @if($product->in_stock==1)
                                        data-toast="cart_toast"
                                    id="add_to_cart_single"
                                    hx-post="{{route('cart.add.single')}}"
                                    hx-target="#cart_icon_number"
                                    hx-vals='{"_token":"{{csrf_token()}}","product_id":"{{$product->id}}"}'
                                    @endif
                                    class="{{$product->in_stock==1 ? 'gradient-highlight' : 'gradient-red' }} btn btn-full btn-s font-900 text-uppercase rounded-sm shadow-l">
                                    @if($product->in_stock==1)
                                        {{__('Add to Cart')}}
                                    @else
                                        <span class="font-13">{{__('Out Of Stock')}}</span>
                                    @endif
                                </button>
                            @endif
                        @endif
                        {{--  share button which is shown on small screen only --}}
                        <a href="#" id="share" onclick="sharePage()"
                           class="icon icon-xs rounded-xl shadow-m ms-2 gradient-highlight">
                            <i class="bi bi-share-fill font-15"></i>
                        </a>
                    </div>
                </div>
            </div>
            @include('frontend.components.contact')
        </div>
    </div>
    {{--     video embeding --}}
    <div style="margin-left: 0;margin-right: 0" class="card card-style">
        @if(auth('admin')->check())
            @include('frontend.product-single.components.product_video')
        @endif
        @if($product->embed_video)
            <div class="content">
                <div class="responsive-iframe rounded-s">
                    <iframe class="rounded-s"
                            title="YouTube video player"
                            referrerpolicy="strict-origin-when-cross-origin"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            src="https://www.youtube.com/embed/{{$product->embed_video}}" frameborder="0"
                            allowfullscreen=""></iframe>
                </div>
            </div>
        @endif
    </div>
    {{--    similar products --}}
    <div style="margin-left: 0;margin-right: 0" class="card card-style">
        <div class="d-flex justify-content-center mb-5 mt-4">
            <a class="text-center w-full font-20"
               href="{{route('category.single',['category'=>$product->category->slug])}}">{{__('Similar Products')}}</a>
        </div>
        <div class="splide   slider-dots-under slider-boxed" id="similar-slider">
            <div class="splide__track">
                <div class="splide__list">
                    @include('frontend.placeholders.similar_slider_items')
                </div>
            </div>
        </div>
    </div>

    <script>
        {{--    share functionality only for mobiles--}}
        if (!/Mobi|Android|iPhone/i.test(navigator.userAgent)) {
            document.getElementById('share').style.display = 'none';
        }

        function sharePage() {
            if (navigator.share) {
                navigator.share({
                    title: document.title,
                    text: '{{$product->name}}',
                    url: window.location.href
                }).catch(err => console.log(err));
            }
            // else {
            //     alert('Sharing not supported on this browser');
            // }
        }

        document.addEventListener('DOMContentLoaded', function () {

            // var thumbnails = new Splide('#thumbnail-slider', {
            //     fixedWidth: 104,
            //     fixedHeight: 58,
            //     focus: 'center',
            //     cover: true,
            //     gap: 10,
            //     rewind: true,
            //     pagination: false,
            //     // isNavigation: true,
            //     // wheel: true,
            // });

            var thumbnails = new Splide('#thumbnail-slider', {
                rewind: true,
                fixedWidth: 104,
                fixedHeight: 58,
                isNavigation: true,
                gap: 10,
                focus: 'center',
                arrows: false,
                pagination: false,
                cover: true,
                dragMinThreshold: {
                    mouse: 4,
                    touch: 10,
                },
                breakpoints: {
                    640: {
                        fixedWidth: 66,
                        fixedHeight: 38,
                    },
                },
            });

            var main = new Splide('#main-slider', {
                fixedWidth: 100,
                rewind: true,
                type: 'fade',
                heightRatio: 0.5,
                pagination: false,
                arrows: false,
                cover: true,
            })

            // Sync sliders
            thumbnails.mount();
            main.sync(thumbnails);
            main.mount();


            new Splide('#similar-slider', {
                autoPlay: true,
                arrows: false,
                perPage: 5,
                gap:'10px',
                autoplay: true,
                lazyLoad: 'nearby',
                interval: 2000,
                breakpoints: {
                    1200: {
                        perPage: 4,
                        padding: '1rem',
                        drag: true,
                    },
                    768: {
                        perPage: 3,
                        padding: '1rem',
                        drag: true,
                    },
                    480: {
                        perPage: 2,
                        padding: 0,
                        type: 'loop',
                        drag: true,
                    },
                },
            }).mount();

        });





    </script>

    @push('js')
        @if(auth('admin')->check())
            <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
            <script>
                window.Quill = Quill;

                @foreach($locales as $locale)
                const quill{{$locale->abbr}} = new Quill('#editor{{$locale->abbr}}', {
                    theme: 'snow',
                    placeholder: 'აღწერეთ პროდუქტი დეტალურად...',
                    modules: {
                        // imageResize is removed from here
                        toolbar: [
                            [{'header': [1, 2, 3, 4, 5, 6, false]}],
                            [{'font': []}],
                            [{'size': ['small', false, 'large', 'huge']}],
                            ['bold', 'italic', 'underline', 'strike'],
                            ['blockquote'],
                            [{'color': []}, {'background': []}],
                            [{'script': 'sub'}, {'script': 'super'}],
                            [{'list': 'ordered'}, {'list': 'bullet'}],
                            [{'indent': '-1'}, {'indent': '+1'}],
                            [{'direction': 'rtl'}],
                            [{'align': []}],
                            ['link', 'image', 'video'],
                            ['clean']
                        ]
                    },
                    // Maximum compatible formats for Quill 2.0.3
                    formats: [
                        'header', 'font', 'size',
                        'bold', 'italic', 'underline', 'strike',
                        'color', 'background',
                        'script', 'blockquote',
                        'list', 'indent', 'direction',
                        'align', 'link', 'image', 'video'
                    ]
                });
                @endforeach

                const form = document.getElementById('description_form')

                form.addEventListener('submit', function (e) {
                    e.preventDefault()
                    @foreach($locales as $locale)
                    let html{{$locale->abbr}} = quill{{$locale->abbr}}.root.innerHTML;
                    document.getElementById('description_{{$locale->abbr}}').value = html{{$locale->abbr}}
                    @endforeach
                    form.submit()
                });
            </script>
        @endif
    @endpush

@endsection
