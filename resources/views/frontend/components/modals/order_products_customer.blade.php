<div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme w-100"
     style=" max-width:800px; max-height: 78vh; overflow-y: auto; overflow-x: hidden;"
     id="order_products_{{$order->order_token}}">
    <div class="content mx-1 ms-1">
        <div class="d-flex justify-content-center">
            <h5>{{__('Order No')}} {{$order->order_token}} - {{$order->created_at->format('d/m/Y')}}</h5>
        </div>
        <div class="card p-2 card-style m-0">
            @if($order->products_details)
                <div class="table-responsive">
                    <table class="table color-theme mb-2">
                        <th scope="col" class="text-center">
                            {{__('Product')}}
                        </th>
                        <th scope="col" class="text-center">
                            {{__('Price')}}
                        </th>
                        <th scope="col" class="text-center">
                            {{__('Quantity')}}
                        </th>
                        <th scope="col" class="text-center">
                            {{__('Coupon Discount')}}
                        </th>
                        <th scope="col" class="text-center">
                            {{__('Total')}}
                        </th>
                        <tbody>
                        @foreach($order->products_details as $item)
                            <tr>
                                <td class="text-center">
                                    <a target="_blank" href="{{route('product.single',[ 'locale'=>app()->getLocale(),'product'=>$item['id']])}}">
                                        <img loading="lazy" style="width: 150px" src="{{$item['image']}}" alt="">
                                        <p style="color:blue" class="mt-2">{{$item['name']}}</p>
                                    </a>
                                </td>
                                <td class="text-center">{{$item['price']}}</td>
                                <td class="text-center">{{$item['quantity']}}</td>
                                <td class="text-center">{{ number_format($item['coupon_discount'] * $item['quantity'], 2) }}</td>
                                <td class="text-center">{{$item['product_total']}}</td>
                            </tr>
                        @endforeach
                        @if(count($order->products_details) >1 && $order->city)
                            <tr style="background: lightslategray">
                                <td>{{__('Total')}}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-center">{{$order->total_price}}</td>
                            </tr>
                        @endif
                        <tr style="background: lightslategray">
                            <td class="text-center">{{__('Shipping')}} ({{$order->city?->name}})</td>
                            <td></td>
                            <td class="text-center"></td>
                            <td></td>
                            <td class="text-center">{{$order->shipping_cost}}</td>
                        </tr>
                        <tr style="background: lightslategray">
                            <td class="text-center">{{__('Grand Total')}}</td>
                            <td></td>
                            <td></td>
                            <td class="text-center"></td>
                            <td class="text-center">{{$order->grand_total}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
