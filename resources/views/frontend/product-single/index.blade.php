@extends('frontend.components.layout')

@section('product-single')

    <div class="card card-style preload-img bg-333" data-card-height="400">
        <div class="card-bottom ms-3">
            <span class="bg-highlight color-white font-700 p-2 rounded-s">$25.00</span>
            <h1 class="font-40 font-900 line-height-xl mt-4 color-white mb-3">Sticky Mobile</h1>
        </div>
        <div class="card-overlay bg-gradient"></div>
    </div>

    <div class="card card-style">
        <div class="content">
            <p>
                The best selling Mobile Progressive Web App on the Envato Marketplaces just got even better now, with
                4.0 introducing
                Bootstrap 5.x compatibility and a tone of new gorgeous features!
            </p>
            <div class="row mb-0">
                <div class="col-4">
                    <span class="font-11">PWA</span>
                    <p class="mt-n2 mb-3">
                        <strong class="color-theme">Yes</strong>
                    </p>
                </div>
                <div class="col-4">
                    <span class="font-11">Boostrap</span>
                    <p class="mt-n2 mb-3">
                        <strong class="color-theme">5.x</strong>
                    </p>
                </div>
                <div class="col-4">
                    <span class="font-11">Dark Mode</span>
                    <p class="mt-n2 mb-3">
                        <strong class="color-theme">Yes</strong>
                    </p>
                </div>
                <div class="col-4">
                    <span class="font-11">Cordova</span>
                    <p class="mt-n2 mb-3">
                        <strong class="color-theme">Compatible</strong>
                    </p>
                </div>
                <div class="col-4">
                    <span class="font-11">Components</span>
                    <p class="mt-n2 mb-3">
                        <strong class="color-theme">100+</strong>
                    </p>
                </div>
                <div class="col-4">
                    <span class="font-11">Total Pages</span>
                    <p class="mt-n2 mb-3">
                        <strong class="color-theme">250+</strong>
                    </p>
                </div>
            </div>

            <div class="divider mt-3"></div>

            <div class="d-flex">
                <div class="flex-grow-1">
                    <span class="font-11">Share with the World </span>
                    <p class="mt-n2">
                        <strong class="color-theme">Share or Save for Later</strong>
                    </p>
                </div>
                <div class="flex-shrink-1 mt-1">
                    <a href="#" data-menu="menu-share" class="icon icon-xs rounded-xl shadow-m ms-2 bg-blue-dark">
                        <i class="bi bi-share-fill font-15"></i>
                    </a>
                </div>
            </div>

            <div class="d-flex justify-content-center pt-4">
                <div class="d-flex gap-2">
                    <div class="align-self-center">
                        <div class="stepper rounded-s">
                            <a href="#" class="stepper-sub float-start"><i
                                    class="bi bi-dash font-18 color-red-dark"></i></a>
                            <input type="number" class="color-theme" min="1" max="99" value="1">
                            <a href="#" class="stepper-add float-end"><i
                                    class="bi bi-plus font-18 color-green-dark"></i></a>
                        </div>
                    </div>
                    <div class="w-100  ms-auto">
                        <a href="#" data-toast="snackbar-cart"
                           class="btn btn-full btn-s font-900 text-uppercase rounded-sm shadow-l bg-blue-dark ms-3">
                            Add to Cart
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-style">
        <div class="content mb-0">
            <h2>Product Gallery</h2>
            <div class="row text-center row-cols-3 mb-0">
                <a class="col mb-4" data-gallery="gallery-1" href="{{asset('frontassets/images/test/1.webp')}}"
                   title="Vynil and Typerwritter">
                    <img src="{{asset('frontassets/images/test/1.webp')}}"
                         data-src="{{asset('frontassets/images/test/1.webp')}}" class="img-fluid rounded-m preload-img"
                         alt="img">
                </a>
                <a class="col mb-4" data-gallery="gallery-1" href="{{asset('frontassets/images/test/1-1.webp')}}"
                   title="Cream Cookie">
                    <img src="{{asset('frontassets/images/test/1-1.webp')}}"
                         data-src="{{asset('frontassets/images/test/1-1.webp')}}"
                         class="img-fluid rounded-m preload-img" alt="img">
                </a>
                <a class="col mb-4" data-gallery="gallery-1" href="{{asset('frontassets/images/test/2.webp')}}"
                   title="Cookies and Flowers">
                    <img src="{{asset('frontassets/images/test/2.webp')}}"
                         data-src="{{asset('frontassets/images/test/2.webp')}}" class="img-fluid rounded-m preload-img"
                         alt="img">
                </a>
                <a class="col mb-4" data-gallery="gallery-1" href="{{asset('frontassets/images/test/3.webp')}}"
                   title="Pots and Pans">
                    <img src="{{asset('frontassets/images/test/3.webp')}}"
                         data-src="{{asset('frontassets/images/test/3.webp')}}" class="img-fluid rounded-m preload-img"
                         alt="img">
                </a>
                <a class="col mb-4" data-gallery="gallery-1" href="{{asset('frontassets/images/test/1-1.webp')}}"
                   title="Cookies and Flowers">
                    <img src="{{asset('frontassets/images/test/1-1.webp')}}"
                         data-src="{{asset('frontassets/images/test/1-1.webp')}}"
                         class="img-fluid rounded-m preload-img" alt="img">
                </a>
                <a class="col mb-4" data-gallery="gallery-1" href="{{asset('frontassets/images/test/3.webp')}}"
                   title="Pots and Pans">
                    <img src="{{asset('frontassets/images/test/3.webp')}}"
                         data-src="{{asset('frontassets/images/test/3.webp')}}" class="img-fluid rounded-m preload-img"
                         alt="img">
                </a>
            </div>
        </div>
    </div>

    <div class="card card-style">
        <div class="content mb-4">
            <p>Similar Products</p>
        </div>
        <div class="splide  dynamic-slider slider-dots-under slider-boxed" id="dynamic-slider">
            <div class="splide__track">
                <div class="splide__list">
                    <div class="splide__slide">
                        <div class="col-12 p-0">
                            <div class="card card-style custom-card m-0 bg-333" data-card-height="140">
                                <div class="card-top p-2">
                                    <span class="bg-green-dark p-2 py-1 rounded-2 font-13 font-600">-50%</span>
                                </div>
                            </div>
                            <h5 class="font-600 font-16 line-height-sm pt-3">dfgdfgdffgdf te Leather Band</h5>
                            <span class="color-blue-dark d-block font-11 font-600">Featured this Week</span>
                            <h2 class="pb-3 mt-n1">$2999.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                        </div>
                    </div>
                    <div class="splide__slide">
                        <div class="col-12 p-0">
                            <div class="card card-style custom-card m-0 bg-30" data-card-height="140">
                                <div class="card-top p-2">
                                    <span class="bg-green-dark p-2 py-1 rounded-2 font-13 font-600">-50%</span>
                                </div>
                            </div>
                            <h5 class="font-600 font-16 line-height-sm pt-3">Apple Watch, Ceramic Edition, White Leather
                                Band</h5>
                            <span class="color-blue-dark d-block font-11 font-600">Featured this Week</span>
                            <h2 class="pb-3 mt-n1">$2999.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                        </div>
                    </div>
                    <div class="splide__slide">
                        <div class="col-12 p-0">
                            <div class="card card-style custom-card m-0 bg-30" data-card-height="140">
                                <div class="card-top p-2">
                                    <span class="bg-green-dark p-2 py-1 rounded-1 font-13 font-600">-50%</span>
                                </div>
                            </div>
                            <h5 class="font-600 font-16 line-height-sm pt-3">dfgdfgdffgdf te Leather Band</h5>
                            <span class="color-blue-dark d-block font-11 font-600">Featured this Week</span>
                            <h2 class="pb-3 mt-n1">$2999.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                        </div>
                    </div>
                    <div class="splide__slide">

                        <div class="col-12 p-0">
                            <div class="card card-style custom-card m-0 bg-30" data-card-height="140">
                                <div class="card-top p-2">
                                    <span class="bg-green-dark p-2 py-1 rounded-1 font-13 font-600">-50%</span>
                                </div>
                            </div>
                            <h5 class="font-600 font-16 line-height-sm pt-3">Apple Watch, Ceramic Edition, White Leather
                                Band</h5>
                            <span class="color-blue-dark d-block font-11 font-600">Featured this Week</span>
                            <h2 class="pb-3 mt-n1">$2999.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                        </div>
                    </div>
                    <div class="splide__slide">
                        <div class="col-12 p-0">
                            <div class="card card-style custom-card m-0 bg-30" data-card-height="140">
                                <div class="card-top p-2">
                                    <span class="bg-green-dark p-2 py-1 rounded-1 font-13 font-600">-50%</span>
                                </div>
                            </div>
                            <h5 class="font-600 font-16 line-height-sm pt-3">dfgdfgdffgdf te Leather Band</h5>
                            <span class="color-blue-dark d-block font-11 font-600">Featured this Week</span>
                            <h2 class="pb-3 mt-n1">$2999.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                        </div>
                    </div>
                    <div class="splide__slide">

                        <div class="col-12 p-0">
                            <div class="card card-style custom-card m-0 bg-30" data-card-height="140">
                                <div class="card-top p-2">
                                    <span class="bg-green-dark p-2 py-1 rounded-1 font-13 font-600">-50%</span>
                                </div>
                            </div>
                            <h5 class="font-600 font-16 line-height-sm pt-3">Apple Watch, Ceramic Edition, White Leather
                                Band</h5>
                            <span class="color-blue-dark d-block font-11 font-600">Featured this Week</span>
                            <h2 class="pb-3 mt-n1">$2999.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
