<div class="content">
    <div class="d-flex justify-content-center">
        <h5>Cart {{$cart->cart_token}} - {{$order->created_at->format('d/m/Y')}}</h5>
    </div>
    <div class="card p-2 card-style m-0">
        @if($order->products_details)
            <table class="table color-theme mb-2">
                <th scope="col" class="text-center">
                    {{__('Product')}}
                </th>
                <th scope="col" class="text-center">
                    SKU
                </th>
                <th scope="col" class="text-center">
                    Price
                </th>
                <th scope="col" class="text-center">
                    Quantity
                </th>
                <th scope="col" class="text-center">
                    Coupon Discount
                </th>
                <th scope="col" class="text-center">
                    Total
                </th>
                <tbody>
                @foreach($products as $item)
                    <tr>
                        <td class="text-center">{{$item['name']}}</td>
                        <td class="text-center">{{$item['sku']}}</td>
                        <td class="text-center">{{$item['price']}}</td>
                        <td class="text-center">{{$item['quantity']}}</td>
                        <td class="text-center">{{ number_format($item['coupon_discount'] * $item['quantity'], 2) }}</td>
                        <td class="text-center">{{$item['product_total']}}</td>
                    </tr>
                @endforeach
                @if(count($order->products_details) >1 && $order->city)
                    <tr style="background: lightslategray">
                        <td class="text-center">Total</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td  class="text-center">{{$order->total_price}}</td>
                    </tr>
                @endif
                <tr style="background: lightslategray">
                    <td class="text-center">Shipping ({{$order->city?->name}})</td>
                    <td></td>
                    <td></td>

                    <td  class="text-center"></td>
                    <td></td>
                    <td  class="text-center">{{$order->shipping_cost}}</td>
                </tr>
                <tr style="background: lightslategray">
                    <td class="text-center">Grand Total</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td  class="text-center"></td>
                    <td  class="text-center">{{$order->grand_total}}</td>
                </tr>
                </tbody>
            </table>
        @endif
    </div>
</div>
