@extends('frontend.components.layout')

@section('index')
    {{--    <div class="splide single-slider slider-no-dots slider-no-arrows slider-boxed text-center mt-n2"--}}
    {{--         id="single-slider-3">--}}
    {{--        <div class="splide__track">--}}
    {{--            <div class="splide__list">--}}
    {{--                <div class="splide__slide d-flex justify-content-center">--}}
    {{--                    <div class="card card-style mx-0 shadow-card shadow-card-m bg-333 dynamic-width" data-card-height="230">--}}
    {{--                        <div class="card-bottom pb-3 px-3">--}}
    {{--                            <h3 class="color-white mb-1 custom-h1">რაიმე ტექსტი ქართულად</h3>--}}
    {{--                            <p class="color-white opacity-80 mb-0 mt-n1 font-14">Duo is now Better than Ever!</p>--}}
    {{--                        </div>--}}
    {{--                        <div class="card-overlay bg-gradient-fade"></div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}

    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    <div class="card card-style bg-333 text-center shadow-card shadow-card-l" data-card-height="340"
         style="height: 340px;">
        <div class="card-center">
            <h1 class="color-white mb-0">35k+ Happy Customers</h1>
            <p class="color-white opacity-60 mb-2">No stone left unturned, no aspect overlooked!</p>
            <p class="text-center color-yellow-dark py-2 mb-2">
                <i class="bi bi-star-fill color-yellow-light font-20"></i>
                <i class="bi bi-star-fill color-yellow-light font-24 px-1"></i>
                <i class="bi bi-star-fill color-yellow-light font-28 px-1"></i>
                <i class="bi bi-star-fill color-yellow-light font-24 px-1"></i>
                <i class="bi bi-star-fill color-yellow-light font-20"></i>
            </p>
            <div
                class="splide single-slider slider-no-arrows slider-no-dots splide--loop splide--ltr splide--draggable is-active"
                id="single-slider-quotes" style="visibility: visible;">
                <div class="splide__arrows">
                    <button class="splide__arrow splide__arrow--prev" type="button"
                            aria-controls="single-slider-quotes-track" aria-label="Previous slide">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" width="40" height="40">
                            <path
                                d="m15.5 0.932-4.3 4.38 14.5 14.6-14.5 14.5 4.3 4.4 14.6-14.6 4.4-4.3-4.4-4.4-14.6-14.6z"></path>
                        </svg>
                    </button>
                    <button class="splide__arrow splide__arrow--next" type="button"
                            aria-controls="single-slider-quotes-track" aria-label="Go to first slide">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" width="40" height="40">
                            <path
                                d="m15.5 0.932-4.3 4.38 14.5 14.6-14.5 14.5 4.3 4.4 14.6-14.6 4.4-4.3-4.4-4.4-14.6-14.6z"></path>
                        </svg>
                    </button>
                </div>
                <div class="splide__track" id="single-slider-quotes-track">
                    <div class="splide__list" id="single-slider-quotes-list" style="transform: translateX(-5712px);">
                        <div class="splide__slide splide__slide--clone" aria-hidden="true" tabindex="-1"
                             style="width: 1904px;">
                            <p class="font-16 font-400 color-white line-height-xl mx-4 mb-0">
                                The best support I have ever had, it's so good I purchased another template. Highlighy
                                Recommended.
                                <br>
                                <a href="#" class="pt-4 color-highlight font-13 mb-0">Envato Customer</a>
                            </p>
                        </div>
                        <div class="splide__slide splide__slide--clone" style="width: 1904px;">
                            <p class="font-16 font-400 color-white line-height-xl mx-4 mb-0">
                                The code is always great with any Enabled template, but it's the customer support that
                                wins me over.<br>
                                <a href="#" class="pt-4 color-highlight font-13 mb-0">Envato Customer</a>
                            </p>
                        </div>
                        <div class="splide__slide" id="single-slider-quotes-slide01" aria-hidden="true" tabindex="-1"
                             style="width: 1904px;">
                            <p class="font-16 font-400 color-white line-height-xl mx-4 mb-0">
                                The best support I have ever had, it's so good I purchased another template. Highlighy
                                Recommended.
                                <br>
                                <a href="#" class="pt-4 color-highlight font-13 mb-0">Envato Customer</a>
                            </p>
                        </div>
                        <div class="splide__slide is-active is-visible" id="single-slider-quotes-slide02"
                             aria-hidden="false" tabindex="0" style="width: 1904px;">
                            <p class="font-16 font-400 color-white line-height-xl mx-4 mb-0">
                                The code is always great with any Enabled template, but it's the customer support that
                                wins me over.<br>
                                <a href="#" class="pt-4 color-highlight font-13 mb-0">Envato Customer</a>
                            </p>
                        </div>
                        <div class="splide__slide splide__slide--clone" style="width: 1904px;">
                            <p class="font-16 font-400 color-white line-height-xl mx-4 mb-0">
                                The best support I have ever had, it's so good I purchased another template. Highlighy
                                Recommended.
                                <br>
                                <a href="#" class="pt-4 color-highlight font-13 mb-0">Envato Customer</a>
                            </p>
                        </div>
                        <div class="splide__slide splide__slide--clone" style="width: 1904px;">
                            <p class="font-16 font-400 color-white line-height-xl mx-4 mb-0">
                                The code is always great with any Enabled template, but it's the customer support that
                                wins me over.<br>
                                <a href="#" class="pt-4 color-highlight font-13 mb-0">Envato Customer</a>
                            </p>
                        </div>
                    </div>
                </div>
                <ul class="splide__pagination">
                    <li>
                        <button class="splide__pagination__page" type="button"
                                aria-controls="single-slider-quotes-slide01" aria-label="Go to slide 1"></button>
                    </li>
                    <li>
                        <button class="splide__pagination__page is-active" type="button"
                                aria-controls="single-slider-quotes-slide02" aria-label="Go to slide 2"
                                aria-current="true"></button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-overlay bg-black opacity-70"></div>
    </div>

    {{--  featured  --}}
    <div class="splide  dynamic-slider slider-dots-under slider-boxed" id="dynamic-slider">
        <h2 class="text-center mb-3">Featured</h2>
        <div class="splide__track">
            <div class="splide__list">
                <div class="splide__slide">
                    <div>
                        <a href="{{route('product-single')}}" class="col-12 p-0">
                            <div class="card card-style custom-card m-0 bg-333" data-card-height="140">
                                <div class="card-top p-2">
                                    <span class="bg-green-dark p-2 py-1 rounded-2 font-13 font-600">-50%</span>
                                </div>
                            </div>
                            <h5 class="font-600 font-16 line-height-sm pt-3">dfgdfgdffgdf te Leather Band</h5>
                        </a>

                        <div class="d-flex flex-column  flex-md-row gap-2 justify-content-start align-items-center">
                            <h6 class=" font-20">₾2999.<sup class="font-14 font-400 opacity-50">99</sup></h6>
                            <div class="align-self-center">
                                <div class="stepper rounded-s">
                                    <a href="#" class="stepper-sub float-start"><i
                                            class="bi bi-dash font-18 color-red-dark"></i></a>
                                    <input type="number" class="color-theme" min="1" max="99" value="1">
                                    <a href="#" class="stepper-add float-end"><i
                                            class="bi bi-plus font-18 color-green-dark"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="w-100 mt-2">
                            <a href="#" data-toast="snackbar-cart"
                               class="btn btn-full btn-s font-900 text-uppercase rounded-sm shadow-l bg-blue-dark">
                                Add to Cart
                            </a>
                        </div>
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

    <div class="divider mx-3 mt-5 mb-4"></div>
    {{--  catgories  --}}
    <div class="card card-style mx-0">
        <div class="content">
            <h2 class="text-center mb-3">Category</h2>
            <div class="row mb-0 justify-content-center">
                <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                    <div class="card card-style custom-card m-0 bg-21" data-card-height="140" style="height: 140px;">

                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip
                        M9X</h5>
                    <span class="color-green-dark d-block font-11 font-600">In Stock</span>
                    <h2 class="mt-n1">$2499.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-sm-6 col-md-4 col-lg-3 ">
                    <div class="card card-style custom-card m-0 bg-21" data-card-height="140" style="height: 140px;">

                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip
                        M9X</h5>
                    <span class="color-green-dark d-block font-11 font-600">In Stock</span>
                    <h2 class="mt-n1">$2499.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                    <div class="card card-style custom-card m-0 bg-21" data-card-height="140" style="height: 140px;">

                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip
                        M9X</h5>
                    <span class="color-green-dark d-block font-11 font-600">In Stock</span>
                    <h2 class="mt-n1">$2499.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-sm-6 col-md-4 col-lg-3 ">
                    <div class="card card-style custom-card m-0 bg-21" data-card-height="140" style="height: 140px;">

                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip
                        M9X</h5>
                    <span class="color-green-dark d-block font-11 font-600">In Stock</span>
                    <h2 class="mt-n1">$2499.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                    <div class="card card-style custom-card m-0 bg-21" data-card-height="140" style="height: 140px;">

                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip
                        M9X</h5>
                    <span class="color-green-dark d-block font-11 font-600">In Stock</span>
                    <h2 class="mt-n1">$2499.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                    <div class="card card-style custom-card m-0 bg-21" data-card-height="140" style="height: 140px;">

                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip
                        M9X</h5>
                    <span class="color-green-dark d-block font-11 font-600">In Stock</span>
                    <h2 class="mt-n1">$2499.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-sm-6 col-md-4 col-lg-3 ">
                    <div class="card card-style custom-card m-0 bg-21" data-card-height="140" style="height: 140px;">

                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip
                        M9X</h5>
                    <span class="color-green-dark d-block font-11 font-600">In Stock</span>
                    <h2 class="mt-n1">$2499.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
            </div>
            <a href="#" style="max-width: 200px" class="btn-full btn gradient-green shadow-bg shadow-bg-m">
                View All
            </a>
        </div>
    </div>
    {{--  catgories  --}}
    <div class="card card-style mx-0">
        <div class="content">
            <h2 class="text-center mb-3">Category</h2>
            <div class="row mb-0 justify-content-center">
                <div class="col-6 col-lg-2">
                    <div class="card card-style m-0 bg-30" data-card-height="140" style="height: 140px;">
                        <div class="card-top p-2">
                            <span class="bg-green-dark p-2 py-1 rounded-sm font-13 font-600">-50%</span>
                        </div>
                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Apple Watch, Ceramic Edition, White Leather
                        Band</h5>
                    <span class="color-blue-dark d-block font-11 font-600">Featured this Week</span>
                    <h2 class="pb-3 mt-n1">$2999.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="card card-style m-0 bg-28" data-card-height="140" style="height: 140px;">
                        <div class="card-top p-2">
                            <span class="bg-red-dark p-2 py-1 rounded-sm font-13 font-600">-50%</span>
                        </div>

                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Air, 256GB SSD, 16GB DDR4, Apple Chip
                        M5X</h5>
                    <span class="color-red-dark d-block font-11 font-600">Out of Stock</span>
                    <h2 class="pb-3 mt-n1">$1999.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="card card-style m-0 bg-21" data-card-height="140" style="height: 140px;">

                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip
                        M9X</h5>
                    <span class="color-green-dark d-block font-11 font-600">In Stock</span>
                    <h2 class="mt-n1">$2499.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="card card-style m-0 bg-21" data-card-height="140" style="height: 140px;">

                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip
                        M9X</h5>
                    <span class="color-green-dark d-block font-11 font-600">In Stock</span>
                    <h2 class="mt-n1">$2499.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="card card-style m-0 bg-21" data-card-height="140" style="height: 140px;">

                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip
                        M9X</h5>
                    <span class="color-green-dark d-block font-11 font-600">In Stock</span>
                    <h2 class="mt-n1">$2499.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="card card-style m-0 bg-21" data-card-height="140" style="height: 140px;">

                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip
                        M9X</h5>
                    <span class="color-green-dark d-block font-11 font-600">In Stock</span>
                    <h2 class="mt-n1">$2499.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <a href="#" style="max-width: 200px" class="btn-full btn gradient-green shadow-bg shadow-bg-m">
                    View All
                </a>
            </div>
        </div>
    </div>

@endsection
