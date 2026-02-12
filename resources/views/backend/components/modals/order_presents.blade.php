{{--<div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme w-100"--}}
{{--     style=" max-width:800px; max-height: 78vh; overflow-y: auto; overflow-x: hidden;"--}}
{{--     id="order_presents_{{$order->order_token}}">--}}
{{--    <div class="content">--}}
{{--        <div class="d-flex justify-content-center">--}}
{{--            <h5>Order Presents {{$order->order_token}} - {{$order->created_at->format('d/m/Y')}}</h5>--}}
{{--        </div>--}}
{{--        <div class="card p-2 card-style m-0">--}}
{{--            <table class="table color-theme mb-2">--}}
{{--                <th scope="col" class="text-center">--}}
{{--                    {{__('Product')}}--}}
{{--                </th>--}}
{{--                <th scope="col" class="text-center">--}}
{{--                    SKU--}}
{{--                </th>--}}
{{--                <th scope="col" class="text-center">--}}
{{--                    Price--}}
{{--                </th>--}}
{{--                <tbody>--}}
{{--                @foreach($order->presentsRelation as $present)--}}
{{--                    <tr>--}}
{{--                        <td class="text-center">{{$present->name}}</td>--}}
{{--                        <td class="text-center">{{$present->sku}}</td>--}}
{{--                        <td class="text-center">{{$present->price}}</td>--}}
{{--                    </tr>--}}
{{--                @endforeach--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
<a href="#" data-bs-toggle="offcanvas"
   data-bs-target="#order_presents_{{$order->order_token}}"
   class="default-link btn btn-m rounded-s gradient-highlight shadow-bg shadow-bg-s px-5 mb-0 ">
    {{__('Presents')}}
</a>
<div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme w-100"
     style=" max-width:800px; max-height: 78vh; overflow-y: auto; overflow-x: hidden;"
     id="order_presents_{{$order->order_token}}">
    <div class="content">
        <div class="d-flex justify-content-center">
            <h5>Order Presents {{$order->order_token}} - {{$order->created_at->format('d/m/Y')}}</h5>
        </div>
        <div class="card p-2 card-style m-0">
            <table class="table color-theme mb-2">
                <th scope="col" class="text-center">
                    {{__('Present')}}
                </th>
                <th scope="col" class="text-center">
                    {{__('Product')}}
                </th>
                <th scope="col" class="text-center">
                    {{__('Price')}}
                </th>
                <th scope="col" class="text-center">
                    {{__('Quantity')}}
                </th>
                <tbody>
                @foreach($order->presents as $present)
                    <tr>
                        <td class="text-center">{{$present['name']}}</td>
                        <td class="text-center">{{$present['product_name']}}</td>
                        <td class="text-center">{{$present['price']}}</td>
                        <td class="text-center">{{$present['quantity']}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
