{{ $carttotal ?? 0 }}

<button
         id="add_to_cart_single"
         hx-swap-oob="true"
         hx-post="{{route('cart.add.single')}}"
         hx-target="#cart_icon_number"
         hx-vals='{"_token":"{{csrf_token()}}","product_id":"{{$product}}"}'
         class="btn-full btn gradient-green shadow-bg shadow-bg-m ms-3">
     {{__('Added to cart')}}
</button>
