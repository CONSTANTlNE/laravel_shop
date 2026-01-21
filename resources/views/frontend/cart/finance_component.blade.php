
<div class="d-flex mb-2">
    <div><h5 class="opacity-50 font-500">{{__('Products')}}</h5></div>
    <div class="ms-auto">
        <h5>
            <span id="total_value_no_discount">{{$total_value_no_discount}}</span>
        </h5>
    </div>
</div>

{{--@if($discount_value>0)--}}
<div class="d-flex mb-2">
    <div><h5 class="opacity-50 font-500">{{__('Discount')}}</h5></div>
    <div class="ms-auto">
        <h5>
            <span id="total_discount">{{$discount_value}}</span>
        </h5>
    </div>
</div>
@if($hascoupon)
    <div class="d-flex mb-2">
        <div><h5 class="opacity-50 font-500">{{__('Promo Code')}} {{$promo_code}}</h5></div>
        <div class="ms-auto"><h5>{{$total_coupon_discount}}</h5></div>
    </div>
@endif
<div class="d-flex mb-2">
    <div><h4 class=" font-700">{{__('After Discount')}}</h4></div>
    <div class="ms-auto">
        <h5>
            <span id="total_value">{{$total_value}}</span>
        </h5>
    </div>
</div>
