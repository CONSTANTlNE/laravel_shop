<div class="content" id="totals_swap_oob"  hx-swap-oob="true">
    @include('frontend.cart.finance_component')

    @if($site_settings->use_transportation==1)
        <div class="d-flex mb-2">
            <div><h5 class="opacity-50 font-500">{{__('Transportation')}}</h5></div>
            <div class="ms-auto">
                <h5>{{$shipping_cost}}</h5>
            </div>
        </div>
    @endif
    <div class="d-flex mb-3">
        <div><h4 class="font-700">{{__('Grand Total')}}</h4></div>
        <div class="ms-auto"><h3>{{$grand_total}}</h3></div>
    </div>
    <div class="divider"></div>
    @if($site_settings->use_sms_verification==1 && auth('web')->user()->mobile_verified==1)
        <form
            @if(env('DEV_PURCHASE_TEST'))
                action="{{route('purchase.test')}}"
            @else
                action="{{route('purchase')}}"
            @endif
            id="purchase_form" method="post" class="d-flex justify-content-center">
            @csrf
            <button onclick="spinner(this)" class="btn btn-full bg-highlight btn-m text-uppercase font-800 rounded-sm ">
                {{__('Purchase')}}
            </button>
        </form>
    @else
        <div class="" id="menu-verification" >
            <form class="content"
                  hx-post="{{route('store.mobile.htmx')}}"
                  hx-trigger="submit"
                  hx-target="#menu-verification">
                @csrf
                <h5 class="font-24 font-800 mb-3 text-center">{{__('SMS Verification')}}</h5>
                <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
                    <i class="bi bi-phone font-20"></i>
                    <input type="text" name="mobile" class="form-control rounded-xs" id="mobile_number" placeholder="{{__('Mobile')}}">
                    <label for="mobile_number" class="color-theme">{{__('Mobile')}}</label>
                    <span>({{__('required')}})</span>
                </div>
                <button  style="width: 100%" class="btn btn-full gradient-blue shadow-bg shadow-bg-s mt-4 action-button">{{__('Send')}}</button>
            </form>
        </div>
    @endif
</div>
