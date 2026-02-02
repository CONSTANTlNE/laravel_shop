<div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme w-100"
     style=" max-width:800px; max-height: 78vh; overflow-y: auto; overflow-x: hidden;"
     id="present_products_{{$order->order_token}}">
    <div class="content mx-1 ms-1">
        <div class="d-flex justify-content-center">
            <h5>({{__('Present')}}) {{__('Order No')}} {{$order->order_token}} - {{$order->created_at->format('d/m/Y')}}</h5>
        </div>
        <div class="card p-2 card-style m-0">
            @if($order->products_details)
                <div class="table-responsive">
                    <table class="table color-theme mb-2">
                        <th scope="col" class="text-center">
                            {{__('Preset')}}
                        </th>
                        <th scope="col" class="text-center">
                            {{__('Price')}}
                        </th>
                        <th scope="col" class="text-center">
                            {{__('Quantity')}}
                        </th>
                        <th scope="col" class="text-center">
                            {{__('Total')}}
                        </th>
                        <tbody>
                        @php
                        $total_present=0;
                        @endphp
                        @foreach($order->presents as $present)
                            @php
                                // Add the current item's subtotal to the running total
                                $total_present += ($present['price'] * $present['quantity']);
                            @endphp
                            <tr>
                                <td class="text-center">

                                    <a target="_blank" href="{{route('product.single',[ 'locale'=>app()->getLocale(),'product'=>$present['slug']])}}">
                                        <img loading="lazy" style="width: 150px" src="{{$present['image']}}" alt="">
                                        <p style="color:blue" class="mt-2">{{$present['name']}}</p>
                                    </a>

                                </td>
                                <td class="text-center">{{$present['price']}}</td>
                                <td class="text-center">{{$present['quantity']}}</td>
                                <td class="text-center">{{ number_format($present['price'] * $present['quantity'], 2) }}</td>
                            </tr>
                        @endforeach
                         <tr>
                             <td>{{__('Total')}}</td>
                             <td></td>
                             <td></td>
                             <td>{{$total_present}}</td>
                         </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
