<table class="table color-theme border-blue-dark mb-0">
    <thead class="rounded-s bg-blue-dark border-l">
    <tr class="color-white rounded-sm">
        <th scope="col">
            <h5 class="color-white font-15 mb-0">{{__('Name')}}</h5>
        </th>
        <th scope="col">
            <h5 class="color-white font-15 mb-0">{{__('Price')}} No</h5>
        </th>
        <th scope="col">
            <h5 class="color-white font-15 mb-0">{{__('QTY')}}</h5>
        </th>
        <th scope="col">
            <h5 class="color-white font-15 mb-0">{{__('Image')}}</h5>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($order_items as $item)

        <tr>
            <td>
                <h3 class="font-14 ">{{$item->product->name}}</h3>
            </td>
            <td class="text-center">
                <span>{{$item->product_price}}</span>
                @if($item->coupon_id)
                    <svg style="margin-left:10px" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24">
                        <path fill="#110909"
                              d="M14.8 8L16 9.2L9.2 16L8 14.8zM4 4h16c1.11 0 2 .89 2 2v4a2 2 0 1 0 0 4v4c0 1.11-.89 2-2 2H4a2 2 0 0 1-2-2v-4c1.11 0 2-.89 2-2a2 2 0 0 0-2-2V6a2 2 0 0 1 2-2m0 2v2.54a3.994 3.994 0 0 1 0 6.92V18h16v-2.54a3.994 3.994 0 0 1 0-6.92V6zm5.5 2c.83 0 1.5.67 1.5 1.5S10.33 11 9.5 11S8 10.33 8 9.5S8.67 8 9.5 8m5 5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5s-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5"/>
                    </svg>
                @endif
            </td>
            <td>
                {{$item->quantity}}
            </td>
            <td>
                <div class="">
                    <img
                        @if($item->product->getMedia('product_image')->where('main',1)->first())
                            src="{{ $item->product->getMedia('product_image')->where('main',1)->first()->getUrl() }}"
                        @elseif($item->product->getMedia('product_image')->first())
                            src="{{ $item->product->getMedia('product_image')->first()->getUrl() }}"
                        @endif
                        class="rounded-m shadow-xl" width="130">
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{--total price--}}
<div class="d-flex mb-2 p-2">
    <div><h5 class="opacity-50 font-500">Products</h5></div>
    <div class="ms-auto">
        <h5>
            <span id="">{{$item->order->total_price}}</span>
        </h5>
    </div>
</div>

{{--promo discount--}}
<div class="d-flex mb-2  p-2">
    <div>
        <h5 class="opacity-50 font-500">Promo Discount </h5>
    </div>
    <div class="ms-auto">
        <h5>{{$item->order->total_coupon_discount}}</h5>
    </div>
</div>
{{--shipping cost--}}
<div class="d-flex mb-2  p-2">
    <div>
        <h5 class="opacity-50 font-500">Shipping</h5>
    </div>
    <div class="ms-auto">
        <h5>{{$item->order->shipping_cost}}</h5>
    </div>
</div>
{{--after discount--}}
<div class="d-flex mb-2  p-2">
    <div><h4 class=" font-700">After Discount</h4></div>
    <div class="ms-auto">
        <h5>
            <span id="">{{$item->order->grand_total}}</span>
        </h5>
    </div>
</div>
