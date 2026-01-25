@extends('frontend.components.layout')

@section('checkout')

    <div class="text-center pb-3">
        <h2 class="font-700">{{__('Checkout')}}</h2>
    </div>
    @if (session()->has('error'))
        <div id="error_container"
             class="alert bg-fade-red color-red-dark alert-dismissible rounded-s fade show text-center" role="alert">
            <i class="bi bi-exclamation-triangle pe-2"></i>
            <strong>{{__('Attention')}}</strong> - {{ session('error') }}
            <button type="button" class="btn-close opacity-20 font-11 pt-3 mt-1" data-bs-dismiss="alert"
                    aria-label="Close"></button>
        </div>
    @endif
    <div class="d-flex justify-content-center">
        <div style="max-width: 500px">
            <div class="card card-style">
                <div class="content" style="min-width: 300px">
                    @include('frontend.cart.items_component')
                </div>
            </div>

            @if($site_settings->use_transportation==1)
                <div class="card card-style">
                    <div class="content">
                        <h2 class="mb-0 text-center ">
                            {{__('Address')}}
                        </h2>
                        <br>
                        <div class="input-style has-borders no-icon validate-field mb-2">
                            <select name="city_id"
                                    form="purchase_form"
                                    hx-post="{{route('shippingprice.price.get')}}"
                                    hx-trigger="change"
                                    hx-vals='{"_token":"{{csrf_token()}}"}'
                                    hx-target="#cart_icon_number"
                                    class="form-control rounded-xs"
                                    id="">
                                <option value="">{{__('Select City')}}</option>
                                @foreach($cities as $city)
                                    <option
                                        @selected($city->id==$cartItems->first()->city_id) value="{{$city->id}}">{{$city->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-style has-borders no-icon validate-field mb-2">
                            <input type="text" name="address" class="form-control rounded-xs " required
                                   form="purchase_form"
                                   id="form2"
                                   value="{{old('address')}}"
                                   placeholder="{{__('Address')}}">
                        </div>
                    </div>
                </div>
            @endif

            {{--  coupon code  --}}

            @if($hascoupon)
                <div class="card card-style">
                    <div class="content mb-2">
                        <h3>{{__('Coupon Code')}}</h3>
                        <form
                            {{--  action="{{route('coupon.use')}}" --}}
                            hx-post="{{ route('coupon.use') }}"
                            hx-target="#totals_swap_oob"
                            hx-swap="outerHTML"
                            class="d-flex"
                            method="post">
                            @csrf
                            <div class="align-self-center w-100">
                                <div class="input-style has-borders validate-field">
                                    <input type="text" class="form-control rounded-xs" id="form1"
                                           name="coupon_code" placeholder="Enter Code">
                                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                                    <i class="fa fa-check disabled valid color-green-dark"></i>
                                </div>
                            </div>
                            <div class="align-self-center ms-auto">
                                <button
                                    class="btn btn-full bg-green-dark btn-m text-uppercase font-800 rounded-sm mb-0 ms-3">
                                    {{__('Apply')}}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            {{--            <div class="card card-style over-card">--}}
            {{--                <div class="content mb-2">--}}
            {{--                    <select name="city_id"--}}
            {{--                            hx-post="{{route('shippingprice.price.get')}}"--}}
            {{--                            hx-trigger="change"--}}
            {{--                            hx-vals='{"_token":"{{csrf_token()}}"}'--}}
            {{--                            hx-target="#cart_icon_number"--}}
            {{--                            class="form-control rounded-xs"--}}
            {{--                            id="">--}}
            {{--                        <option value="">Please select</option>--}}
            {{--                        @foreach($cities as $city)--}}
            {{--                            <option--}}
            {{--                                @selected($city->id==$cartItems->first()->city_id) value="{{$city->id}}">{{$city->name}}</option>--}}
            {{--                        @endforeach--}}
            {{--                    </select>--}}
            {{--                </div>--}}
            {{--            </div>  --}}

            <div class="card card-style">
                <div class="content" id="totals_swap_oob">
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
                                    <input type="text" name="mobile" class="form-control rounded-xs" id="mobile_number" placeholder="Mobile">
                                    <label for="mobile_number" class="color-theme">{{__('Mobile')}}</label>
                                    <span>({{__('required')}})</span>
                                </div>
                                <button  style="width: 100%" class="btn btn-full gradient-blue shadow-bg shadow-bg-s mt-4 action-button">
                                    {{__('Send')}}
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    @push('js')

    @endpush
@endsection
