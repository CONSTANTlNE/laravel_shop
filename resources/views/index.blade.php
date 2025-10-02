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
                @foreach($featured_products as $featured)
                    <div class="splide__slide">
                        <a href="">
                            <div href="" class="col-12 p-0">
                                <div class="card card-style custom-card m-0 " data-card-height="140"
                                     style="height: 140px;
                                     @if($featured->getMedia('product_image')->where('main',1)->first())
                                         background-image: url({{asset($featured->getMedia('product_image')->where('main',1)->first()->getUrl())}})
                                     @elseif($featured->getMedia('product_image')->first())
                                         background-image: url({{asset($featured->getMedia('product_image')->first()->getUrl())}})
                                      @endif">
                                    @if($featured->price_before_discount)
                                        <div class="card-top p-2 text-start">
                                            <span class="bg-green-dark p-2 py-1 rounded-1 font-13 font-600">-{{$featured->discount_percentage}}%</span>
                                        </div>
                                    @endif
                                </div>
                                <h5 class="font-600 font-16 line-height-sm pt-3 text-center">
                                    {{$featured->name}}
                                </h5>
                            </div>
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <div class="d-flex justify-content-center gap-2">
                                    <h5 class=" font-14">{{$featured->price}}
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 16" width="12"
                                             height="14"
                                             class="md:w-1-4 w-2-0 text-black-600 mb-1">
                                            <path fill="currentColor" fill-rule="evenodd"
                                                  d="M14 8.094c-.017.013-.034.024-.05.039-.33.322-.662.644-.992.968-.015.014-.023.036-.034.055l-.028-.013c-.014-1.18-.352-2.26-1.044-3.233-.693-.974-1.614-1.66-2.751-2.096v.084l.001 4.045c0 .049-.014.082-.05.116L7.966 9.11l-.058.053V3.513c-.137-.015-.268-.038-.4-.043-.233-.01-.468-.017-.702-.011-.197.004-.394.03-.592.042-.047.004-.04.031-.04.06l-.002 1.246c0 1.045-.002 2.09-.001 3.136 0 .048-.014.082-.05.116L5.036 9.11l-.05.045V3.811l-.19.073c-.305.124-.601.265-.878.44-.362.229-.7.484-1.007.782-.312.303-.584.634-.82.995-.296.45-.515.934-.672 1.447-.106.345-.175.696-.206 1.053-.036.423-.042.847.016 1.272.065.48.185.944.37 1.392.17.409.379.798.649 1.153.154.202.319.398.49.587.277.308.596.57.94.805.358.243.738.449 1.14.616.385.16.789.258 1.2.336.354.067.71.082 1.07.082 1.91-.002 3.822 0 5.733 0h.094l-.054.055-1.106 1.08c-.007.006-.012.014-.018.021H.007c.013-.018.024-.039.04-.054.361-.353.724-.705 1.085-1.059.032-.032.065-.043.11-.043h1.861c-.201-.151-.402-.287-.584-.444-.249-.215-.494-.436-.72-.673-.254-.266-.477-.556-.679-.862-.201-.306-.379-.624-.528-.955-.308-.68-.498-1.39-.564-2.132-.039-.44-.038-.88.005-1.319.035-.356.107-.705.196-1.05.092-.361.216-.712.38-1.049.08-.163.152-.33.242-.487.105-.183.216-.365.34-.535.18-.247.363-.493.566-.721.275-.31.585-.587.916-.841.679-.522 1.425-.916 2.25-1.165.046-.014.062-.032.061-.08-.004-.41-.002-.82-.01-1.229-.002-.105.015-.188.111-.245.02-.012.035-.032.052-.048l.975-.953.06-.056v2.343c.58-.07 1.155-.076 1.734.002V2.27l-.001-1.05c0-.046.013-.078.047-.11.366-.352.73-.705 1.095-1.058l.054-.048V.08l.001 1.125v1.333c0 .04.012.056.054.07.198.066.398.13.59.208.612.25 1.176.578 1.695.98.302.234.58.494.839.77.285.304.536.635.756.987.265.424.494.865.652 1.337.092.278.166.562.244.844.029.103.046.21.068.315v.046z"></path>
                                        </svg>
                                    </h5>
                                    @if($featured->price_before_discount)
                                        <del class="opacity-50 font-15 mt-n1">
                                            {{$featured->price_before_discount }}₾
                                        </del>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="divider mx-3 mt-5 mb-4"></div>
    {{--  catgories  --}}
    @foreach($formain as $main)
        <div class="card card-style mx-0">
            <div class="content">
                <div class="d-flex justify-content-center align-items-center gap-2">
                    <h2 class="text-center mb-3">
                        {{$main->category->first()?->name}}
                        {{$main->subcategory->first()?->name}}
                    </h2>
                    {{-- change order --}}
                    @auth('admin')
                        <form method="post" action="{{route('home.order.change')}}"
                              class="d-flex justify-content-center gap-3 mb-3">
                            @csrf
                            <input type="hidden" name="record_id" value="{{$main->id}}">
                            <label class="form-check-label">
                                Order
                            </label>
                            <select name="order" id=""
                                    onchange="this.form.submit()"
                                    style="width: 70px;"
                                    class="form-select rounded-xs px-1">
                                @foreach($formain as $index =>$ggg)
                                    <option
                                        @selected($ggg->order==$main->order)
                                        value="{{$ggg->order}}">
                                        {{$ggg->order}}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    @endauth
                </div>
                <div class="row mb-0 justify-content-center">
                    @if(!$main->subcategory->isEmpty())
                        @foreach($main->subcategory->first()->products as $product)
                            <div
                                class="col-6 col-sm-6 col-md-4 col-lg-3 text-center mb-3 d-flex flex-column justify-content-between ">
                                <a href="{{route('product.single',[app()->getLocale(),$product->slug])}}">
                                    <div class="card card-style custom-card m-0 bg-21"
                                         data-card-height="140"
                                         style="height: 140px;
                                     @if($product->getMedia('product_image')->where('main',1)->first())
                                         background-image: url({{asset($product->getMedia('product_image')->where('main',1)->first()->getUrl())}})
                                     @elseif($product->getMedia('product_image')->first())
                                         background-image: url({{asset($product->getMedia('product_image')->first()->getUrl())}})
                                      @endif">
                                        @if($product->price_before_discount)
                                            <div class="card-top p-2 text-start">
                                                <span class="bg-green-dark p-2 py-1 rounded-1 font-13 font-600">-{{$product->discount_percentage}}%</span>
                                            </div>
                                        @endif
                                        {{--                                        @if($product->in_stock==1)--}}
                                        {{--                                            <span--}}
                                        {{--                                                class="bottom_center color-green-dark d-block font-11 font-600 text-center">In Stock</span>--}}
                                        {{--                                        @else--}}
                                        {{--                                            <span--}}
                                        {{--                                                class="bottom_center color-red-dark d-block font-11 font-600 text-center">Out of Stock</span>--}}
                                        {{--                                        @endif--}}
                                    </div>
                                    <h5 class="font-600 font-16 line-height-sm pt-3 text-center">
                                        {{$product->name}}
                                    </h5>

                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <div class="d-flex justify-content-center gap-2">
                                            <h5 class=" font-14">{{$product->price}}
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 16" width="12"
                                                     height="14"
                                                     class="md:w-1-4 w-2-0 text-black-600 mb-1">
                                                    <path fill="currentColor" fill-rule="evenodd"
                                                          d="M14 8.094c-.017.013-.034.024-.05.039-.33.322-.662.644-.992.968-.015.014-.023.036-.034.055l-.028-.013c-.014-1.18-.352-2.26-1.044-3.233-.693-.974-1.614-1.66-2.751-2.096v.084l.001 4.045c0 .049-.014.082-.05.116L7.966 9.11l-.058.053V3.513c-.137-.015-.268-.038-.4-.043-.233-.01-.468-.017-.702-.011-.197.004-.394.03-.592.042-.047.004-.04.031-.04.06l-.002 1.246c0 1.045-.002 2.09-.001 3.136 0 .048-.014.082-.05.116L5.036 9.11l-.05.045V3.811l-.19.073c-.305.124-.601.265-.878.44-.362.229-.7.484-1.007.782-.312.303-.584.634-.82.995-.296.45-.515.934-.672 1.447-.106.345-.175.696-.206 1.053-.036.423-.042.847.016 1.272.065.48.185.944.37 1.392.17.409.379.798.649 1.153.154.202.319.398.49.587.277.308.596.57.94.805.358.243.738.449 1.14.616.385.16.789.258 1.2.336.354.067.71.082 1.07.082 1.91-.002 3.822 0 5.733 0h.094l-.054.055-1.106 1.08c-.007.006-.012.014-.018.021H.007c.013-.018.024-.039.04-.054.361-.353.724-.705 1.085-1.059.032-.032.065-.043.11-.043h1.861c-.201-.151-.402-.287-.584-.444-.249-.215-.494-.436-.72-.673-.254-.266-.477-.556-.679-.862-.201-.306-.379-.624-.528-.955-.308-.68-.498-1.39-.564-2.132-.039-.44-.038-.88.005-1.319.035-.356.107-.705.196-1.05.092-.361.216-.712.38-1.049.08-.163.152-.33.242-.487.105-.183.216-.365.34-.535.18-.247.363-.493.566-.721.275-.31.585-.587.916-.841.679-.522 1.425-.916 2.25-1.165.046-.014.062-.032.061-.08-.004-.41-.002-.82-.01-1.229-.002-.105.015-.188.111-.245.02-.012.035-.032.052-.048l.975-.953.06-.056v2.343c.58-.07 1.155-.076 1.734.002V2.27l-.001-1.05c0-.046.013-.078.047-.11.366-.352.73-.705 1.095-1.058l.054-.048V.08l.001 1.125v1.333c0 .04.012.056.054.07.198.066.398.13.59.208.612.25 1.176.578 1.695.98.302.234.58.494.839.77.285.304.536.635.756.987.265.424.494.865.652 1.337.092.278.166.562.244.844.029.103.046.21.068.315v.046z"></path>
                                                </svg>
                                            </h5>
                                            @if($product->price_before_discount)
                                                <del class="opacity-50 font-15 mt-n1">
                                                    {{$product->price_before_discount }}₾
                                                </del>
                                            @endif
                                        </div>
                                    </div>
                                </a>

                                <button
                                    @if($product->in_stock==1)
                                        data-toast="cart_toast"
                                    hx-post="{{route('cart.add')}}"
                                    hx-target="#cart_icon_number"
                                    hx-vals='{"product_id":"{{$product->id}}","_token":"{{csrf_token()}}"}'
                                    @endif
                                    class="{{$product->in_stock==1 ? 'gradient-highlight' : 'gradient-red' }} btn-full btn shadow-bg shadow-bg-m  pt-1 pb-2">
                                    @if($product->in_stock==1)
                                        <i class="bi bi-cart4 font-13"></i>
                                        Add
                                    @else
                                        <span class="font-13">Out Of Stock</span>
                                    @endif
                                </button>
                            </div>
                        @endforeach
                    @else
                        @foreach($main->category->first()->products as $product)
                            <div
                                class="col-6 col-sm-6 col-md-4 col-lg-3 text-center mb-3 d-flex flex-column justify-content-between ">
                                <a href="{{route('product.single',[app()->getLocale(),$product->slug])}}">
                                    <div class="card card-style custom-card m-0 bg-21"
                                         data-card-height="140"
                                         style="height: 140px; position:relative;
                                      @if($product->getMedia('product_image')->where('main',1)->first())
                                         background-image: url({{asset($product->getMedia('product_image')->where('main',1)->first()->getUrl())}})
                                     @elseif($product->getMedia('product_image')->first())
                                         background-image: url({{asset($product->getMedia('product_image')->first()->getUrl())}})
                                     @endif">
                                        @if($product->price_before_discount)
                                            <div class="card-top p-2 text-start">
                                                <span class="bg-green-dark p-2 py-1 rounded-1 font-13 font-600">-{{$product->discount_percentage}}%</span>
                                            </div>
                                        @endif

                                        {{--                                        @if($product->in_stock==1)--}}
                                        {{--                                            <span--}}
                                        {{--                                                class="bottom_center color-green-dark d-block font-11 font-600 text-center">In Stock</span>--}}
                                        {{--                                        @else--}}
                                        {{--                                            <span--}}
                                        {{--                                                class="bottom_center color-red-dark d-block font-11 font-600 text-center">Out of Stock</span>--}}
                                        {{--                                        @endif--}}
                                    </div>

                                    <h5 class="font-600 font-15 line-height-sm pt-3 text-center">
                                        {{$product->name}}
                                    </h5>
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <div class="d-flex justify-content-center gap-2">
                                            <h5 class=" font-14">{{$product->price}}
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 16" width="12"
                                                     height="14"
                                                     class="md:w-1-4 w-2-0 text-black-600 mb-1">
                                                    <path fill="currentColor" fill-rule="evenodd"
                                                          d="M14 8.094c-.017.013-.034.024-.05.039-.33.322-.662.644-.992.968-.015.014-.023.036-.034.055l-.028-.013c-.014-1.18-.352-2.26-1.044-3.233-.693-.974-1.614-1.66-2.751-2.096v.084l.001 4.045c0 .049-.014.082-.05.116L7.966 9.11l-.058.053V3.513c-.137-.015-.268-.038-.4-.043-.233-.01-.468-.017-.702-.011-.197.004-.394.03-.592.042-.047.004-.04.031-.04.06l-.002 1.246c0 1.045-.002 2.09-.001 3.136 0 .048-.014.082-.05.116L5.036 9.11l-.05.045V3.811l-.19.073c-.305.124-.601.265-.878.44-.362.229-.7.484-1.007.782-.312.303-.584.634-.82.995-.296.45-.515.934-.672 1.447-.106.345-.175.696-.206 1.053-.036.423-.042.847.016 1.272.065.48.185.944.37 1.392.17.409.379.798.649 1.153.154.202.319.398.49.587.277.308.596.57.94.805.358.243.738.449 1.14.616.385.16.789.258 1.2.336.354.067.71.082 1.07.082 1.91-.002 3.822 0 5.733 0h.094l-.054.055-1.106 1.08c-.007.006-.012.014-.018.021H.007c.013-.018.024-.039.04-.054.361-.353.724-.705 1.085-1.059.032-.032.065-.043.11-.043h1.861c-.201-.151-.402-.287-.584-.444-.249-.215-.494-.436-.72-.673-.254-.266-.477-.556-.679-.862-.201-.306-.379-.624-.528-.955-.308-.68-.498-1.39-.564-2.132-.039-.44-.038-.88.005-1.319.035-.356.107-.705.196-1.05.092-.361.216-.712.38-1.049.08-.163.152-.33.242-.487.105-.183.216-.365.34-.535.18-.247.363-.493.566-.721.275-.31.585-.587.916-.841.679-.522 1.425-.916 2.25-1.165.046-.014.062-.032.061-.08-.004-.41-.002-.82-.01-1.229-.002-.105.015-.188.111-.245.02-.012.035-.032.052-.048l.975-.953.06-.056v2.343c.58-.07 1.155-.076 1.734.002V2.27l-.001-1.05c0-.046.013-.078.047-.11.366-.352.73-.705 1.095-1.058l.054-.048V.08l.001 1.125v1.333c0 .04.012.056.054.07.198.066.398.13.59.208.612.25 1.176.578 1.695.98.302.234.58.494.839.77.285.304.536.635.756.987.265.424.494.865.652 1.337.092.278.166.562.244.844.029.103.046.21.068.315v.046z"></path>
                                                </svg>
                                            </h5>
                                            @if($product->price_before_discount)
                                                <del class="opacity-50 font-15 mt-n1">
                                                    {{$product->price_before_discount }}₾
                                                </del>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                                <button
                                    @if($product->in_stock==1)
                                        data-toast="cart_toast"
                                    hx-post="{{route('cart.add')}}"
                                    hx-target="#cart_icon_number"
                                    hx-vals='{"product_id":"{{$product->id}}","_token":"{{csrf_token()}}"}'
                                    @endif
                                    class="{{$product->in_stock==1 ? 'gradient-highlight' : 'gradient-red' }}  btn-full btn  shadow-bg shadow-bg-m pt-1 pb-2">
                                    @if($product->in_stock==1)
                                        <i class="bi bi-cart4 font-15"></i>
                                        Add
                                    @else
                                        <span class="font-13">Out Of Stock</span>
                                    @endif
                                </button>
                            </div>

                        @endforeach
                    @endif
                </div>
                <div class="d-flex justify-content-center mt-1">
                    <a href="{{route('category.single',['category' => $main->category->first()?->slug ? $main->category->first()?->slug : $main->subcategory->first()?->slug])}}"
                       style="max-width: 200px"
                       class="btn-full btn gradient-highlight shadow-bg shadow-bg-m ">
                        View All
                    </a>
                </div>
            </div>
        </div>
    @endforeach
    {{--  catgories  --}}
    {{--    <div class="card card-style mx-0">--}}
    {{--        <div class="content">--}}
    {{--            <h2 class="text-center mb-3">Category</h2>--}}
    {{--            <div class="row mb-0 justify-content-center">--}}
    {{--                <div class="col-6 col-lg-2">--}}
    {{--                    <div class="card card-style m-0 bg-30" data-card-height="140" style="height: 140px;">--}}
    {{--                        <div class="card-top p-2">--}}
    {{--                            <span class="bg-green-dark p-2 py-1 rounded-sm font-13 font-600">-50%</span>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                    <h5 class="font-600 font-16 line-height-sm pt-3">Apple Watch, Ceramic Edition, White Leather--}}
    {{--                        Band</h5>--}}
    {{--                    <span class="color-blue-dark d-block font-11 font-600">Featured this Week</span>--}}
    {{--                    <h2 class="pb-3 mt-n1">$2999.<sup class="font-14 font-400 opacity-50">99</sup></h2>--}}
    {{--                </div>--}}
    {{--                <div class="col-6 col-lg-2">--}}
    {{--                    <div class="card card-style m-0 bg-28" data-card-height="140" style="height: 140px;">--}}
    {{--                        <div class="card-top p-2">--}}
    {{--                            <span class="bg-red-dark p-2 py-1 rounded-sm font-13 font-600">-50%</span>--}}
    {{--                        </div>--}}

    {{--                    </div>--}}
    {{--                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Air, 256GB SSD, 16GB DDR4, Apple Chip--}}
    {{--                        M5X</h5>--}}
    {{--                    <span class="color-red-dark d-block font-11 font-600">Out of Stock</span>--}}
    {{--                    <h2 class="pb-3 mt-n1">$1999.<sup class="font-14 font-400 opacity-50">99</sup></h2>--}}
    {{--                </div>--}}
    {{--                <div class="col-6 col-lg-2">--}}
    {{--                    <div class="card card-style m-0 bg-21" data-card-height="140" style="height: 140px;">--}}

    {{--                    </div>--}}
    {{--                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip--}}
    {{--                        M9X</h5>--}}
    {{--                    <span class="color-green-dark d-block font-11 font-600">In Stock</span>--}}
    {{--                    <h2 class="mt-n1">$2499.<sup class="font-14 font-400 opacity-50">99</sup></h2>--}}
    {{--                </div>--}}
    {{--                <div class="col-6 col-lg-2">--}}
    {{--                    <div class="card card-style m-0 bg-21" data-card-height="140" style="height: 140px;">--}}

    {{--                    </div>--}}
    {{--                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip--}}
    {{--                        M9X</h5>--}}
    {{--                    <span class="color-green-dark d-block font-11 font-600">In Stock</span>--}}
    {{--                    <h2 class="mt-n1">$2499.<sup class="font-14 font-400 opacity-50">99</sup></h2>--}}
    {{--                </div>--}}
    {{--                <div class="col-6 col-lg-2">--}}
    {{--                    <div class="card card-style m-0 bg-21" data-card-height="140" style="height: 140px;">--}}

    {{--                    </div>--}}
    {{--                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip--}}
    {{--                        M9X</h5>--}}
    {{--                    <span class="color-green-dark d-block font-11 font-600">In Stock</span>--}}
    {{--                    <h2 class="mt-n1">$2499.<sup class="font-14 font-400 opacity-50">99</sup></h2>--}}
    {{--                </div>--}}
    {{--                <div class="col-6 col-lg-2">--}}
    {{--                    <div class="card card-style m-0 bg-21" data-card-height="140" style="height: 140px;">--}}

    {{--                    </div>--}}
    {{--                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip--}}
    {{--                        M9X</h5>--}}
    {{--                    <span class="color-green-dark d-block font-11 font-600">In Stock</span>--}}
    {{--                    <h2 class="mt-n1">$2499.<sup class="font-14 font-400 opacity-50">99</sup></h2>--}}
    {{--                </div>--}}
    {{--                <a href="#" style="max-width: 200px" class="btn-full btn gradient-green shadow-bg shadow-bg-m">--}}
    {{--                    View All--}}
    {{--                </a>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

@endsection
