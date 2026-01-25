{{ $carttotal ?? 0 }}

@if ($is_cart == '1' && $item != null)
    <input id="quantity{{ $item->id }}"
           type="number"
           class="color-theme"
           min="1" max="99"
           hx-swap-oob="true"
           value="{{ $item->quantity }}">
@endif

@if ($is_cart == '1')
    {{-- FOR CART --}}
    <span id="total_value_no_discount" hx-swap-oob="true">{{ $total_value_no_discount }}</span>

    @if($discount_value > 0)
        <span id="total_discount" hx-swap-oob="true">{{ $discount_value }}</span>
        <span id="total_value" hx-swap-oob="true">{{ $total_value }}</span>
    @else
        <span id="total_discount" hx-swap-oob="true">0</span>
        <span id="total_value" hx-swap-oob="true">{{ $total_value_no_discount }}</span>
    @endif

    {{--==================  FOR CHECKOUT =====================--}}
    <div class="content" id="totals_swap_oob" hx-swap-oob="true">
        @include('frontend.cart.finance_component')
        <div class="d-flex mb-2">
            <div><h5 class="opacity-50 font-500">{{__('Transportation')}}</h5></div>
            <div class="ms-auto">
                <h5>{{$shipping_cost}}</h5>
            </div>
        </div>

        <div class="d-flex mb-3">
            <div><h4 class="font-700">{{__('Grand Total')}}</h4></div>
            <div class="ms-auto"><h3>{{$grand_total}}</h3></div>
        </div>
        <div class="divider"></div>

        <form @if(env('DEV_PURCHASE_TEST'))
                  action="{{route('purchase.test')}}"
              @else
                  action="{{route('purchase')}}"
              @endif
              id="purchase_form" method="post" class="d-flex justify-content-center">
            @csrf
            <button class="btn btn-full bg-highlight btn-m text-uppercase font-800 rounded-sm">
                {{__('Purchase')}}
            </button>
        </form>
    </div>
@endif
