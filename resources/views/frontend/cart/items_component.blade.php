@foreach($cartItems as $item)
    <div id="removable{{$item->id}}">
        <div class="d-flex">
            <div class="me-3">
                <h3 class="font-14 ">{{$item->product->name}}</h3>
                <h5 class=" font-14 pt-1">
                    <span id="item_price{{$item->id}}">{{$item->product->price}}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 16" width="12"
                         height="14"
                         class="md:w-1-4 w-2-0 text-black-600 mb-1">
                        <path fill="currentColor" fill-rule="evenodd"
                              d="M14 8.094c-.017.013-.034.024-.05.039-.33.322-.662.644-.992.968-.015.014-.023.036-.034.055l-.028-.013c-.014-1.18-.352-2.26-1.044-3.233-.693-.974-1.614-1.66-2.751-2.096v.084l.001 4.045c0 .049-.014.082-.05.116L7.966 9.11l-.058.053V3.513c-.137-.015-.268-.038-.4-.043-.233-.01-.468-.017-.702-.011-.197.004-.394.03-.592.042-.047.004-.04.031-.04.06l-.002 1.246c0 1.045-.002 2.09-.001 3.136 0 .048-.014.082-.05.116L5.036 9.11l-.05.045V3.811l-.19.073c-.305.124-.601.265-.878.44-.362.229-.7.484-1.007.782-.312.303-.584.634-.82.995-.296.45-.515.934-.672 1.447-.106.345-.175.696-.206 1.053-.036.423-.042.847.016 1.272.065.48.185.944.37 1.392.17.409.379.798.649 1.153.154.202.319.398.49.587.277.308.596.57.94.805.358.243.738.449 1.14.616.385.16.789.258 1.2.336.354.067.71.082 1.07.082 1.91-.002 3.822 0 5.733 0h.094l-.054.055-1.106 1.08c-.007.006-.012.014-.018.021H.007c.013-.018.024-.039.04-.054.361-.353.724-.705 1.085-1.059.032-.032.065-.043.11-.043h1.861c-.201-.151-.402-.287-.584-.444-.249-.215-.494-.436-.72-.673-.254-.266-.477-.556-.679-.862-.201-.306-.379-.624-.528-.955-.308-.68-.498-1.39-.564-2.132-.039-.44-.038-.88.005-1.319.035-.356.107-.705.196-1.05.092-.361.216-.712.38-1.049.08-.163.152-.33.242-.487.105-.183.216-.365.34-.535.18-.247.363-.493.566-.721.275-.31.585-.587.916-.841.679-.522 1.425-.916 2.25-1.165.046-.014.062-.032.061-.08-.004-.41-.002-.82-.01-1.229-.002-.105.015-.188.111-.245.02-.012.035-.032.052-.048l.975-.953.06-.056v2.343c.58-.07 1.155-.076 1.734.002V2.27l-.001-1.05c0-.046.013-.078.047-.11.366-.352.73-.705 1.095-1.058l.054-.048V.08l.001 1.125v1.333c0 .04.012.056.054.07.198.066.398.13.59.208.612.25 1.176.578 1.695.98.302.234.58.494.839.77.285.304.536.635.756.987.265.424.494.865.652 1.337.092.278.166.562.244.844.029.103.046.21.068.315v.046z"></path>
                    </svg>
                    @if($item->product->price_before_discount)
                        <a href="#">
                            <sup>
                                <del class="opacity-50 font-14 mt-n1">
                                    {{$item->product->price_before_discount }}₾
                                </del>
                            </sup>
                        </a>
                    @endif
                    @if($item->coupon_id)
                        <svg style="margin-left:10px" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="#110909"
                                  d="M14.8 8L16 9.2L9.2 16L8 14.8zM4 4h16c1.11 0 2 .89 2 2v4a2 2 0 1 0 0 4v4c0 1.11-.89 2-2 2H4a2 2 0 0 1-2-2v-4c1.11 0 2-.89 2-2a2 2 0 0 0-2-2V6a2 2 0 0 1 2-2m0 2v2.54a3.994 3.994 0 0 1 0 6.92V18h16v-2.54a3.994 3.994 0 0 1 0-6.92V6zm5.5 2c.83 0 1.5.67 1.5 1.5S10.33 11 9.5 11S8 10.33 8 9.5S8.67 8 9.5 8m5 5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5s-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5"/>
                        </svg>
                    @endif
                </h5>

                <div class="d-flex justify-content-start gap-2 align-items-center">
                    <div class="stepper rounded-s">
                        <a href="#"
                           hx-post="{{route('cart.remove')}}"
                           hx-target="#cart_icon_number"
                           hx-vals='{"product_id":"{{$item->product->id}}","_token":"{{csrf_token()}}","cart_id":"{{$item->id}}","is_cart":"1"}'
                           {{--                               hx-on::after-request="decrementQuantity({{ $item->id }}, {{$item->product->price}})"--}}
                           {{--                           onclick="decrementQuantity({{ $item->id }},{{$item->product->price}},{{$item->product->price_before_discount}})"--}}
                           class="float-start">
                            <i class="bi bi-dash font-18 color-red-dark"></i>
                        </a>

                        <input id="quantity{{$item?->id}}" type="number" class="color-theme" min="0" max="99"
                               value="{{$item?->quantity}}">

                        <a href="#"
                           hx-post="{{route('cart.add')}}"
                           hx-target="#cart_icon_number"
                           hx-vals='{"product_id":"{{$item->product->id}}","_token":"{{csrf_token()}}","cart_id":"{{$item->id}}","is_cart":"1"}'
                           {{--                           onclick="incrementQuantity({{ $item->id }},{{$item->product->price}},{{$item->product->price_before_discount}})"--}}
                           class=" float-end">
                            <i class="bi bi-plus font-18 color-green-dark"></i>
                        </a>
                    </div>

                    <button style="all:unset;cursor:pointer"
                            hx-post="{{route('cart.delete')}}"
                            hx-target="#cart_icon_number"
                            hx-trigger="click"
                            hx-vals='{"product_id":"{{$item->product->id}}","_token":"{{csrf_token()}}","is_cart":"1"}'
                            hx-on::after-request=" handleRemoval({{$item->id}})"
                            {{--  onclick="handleRemoval({{$item->id}})"--}}
                            class="mt-1">
                        <i class="bi bi-trash color-red-dark font-18"></i>
                    </button>
                </div>
            </div>

            <a href="{{route('product.single',['locale'=>app()->getLocale(),'product'=>$item->product->slug])}}" class="ms-auto position-relative">
                @if($item->product->presents->isNotEmpty())
                    @include('frontend.components.present_svg')
                @endif
                <img
                    @if($item->product->getMedia('product_image')->where('main',1)->first())
                        src="{{ $item->product->getMedia('product_image')->where('main',1)->first()->getUrl('thumbnail') }}"
                    @elseif($item->product->getMedia('product_image')->first())
                        src="{{ $item->product->getMedia('product_image')->first()->getUrl('thumbnail') }}"
                    @endif
                    class="rounded-m shadow-xl" width="130">
            </a>
        </div>

        <div class="divider mt-1"></div>
    </div>

@endforeach
