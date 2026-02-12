<button href="#"
        data-bs-toggle="offcanvas"
        data-bs-target="#orders_{{$user->id}}"
        class="btn btn-full btn-s font-900  rounded-sm shadow-l bg-highlight  mb-1 pt-2 pb-2">
    {{__('Orders')}} - {{$user->orders_count}}
</button>

<div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme w-100"
     style="max-width:800px; max-height: 90vh; overflow-y: auto; overflow-x: hidden;"
     id="orders_{{$user->id}}">
    <div class="card overflow-visible card-style mb-0"
         style="margin-right: 0;margin-left: 0">
        <div class="content">
            <h4>{{$user->name}} - {{__('Orders')}}</h4>
            <div class="border border-blue-dark rounded-s overflow-hidden ">
                <table class="table  mb-0">
                    <thead class="rounded-s bg-blue-dark border-l">
                    <tr class="color-black bg-white">
                        <th scope="col">
                            <h5 class="color-black font-15 mb-0">{{__('Created')}}</h5>
                        </th>
                        <th scope="col">
                            <h5 class="color-black font-15 mb-0">{{__('Order')}} No</h5>
                        </th>
                        <th scope="col">
                            <h5 class="color-black font-15 mb-0">{{__('Shipping')}}</h5>
                        </th>
                        <th scope="col">
                            <h5 class="color-black font-15 mb-0">{{__('City')}}</h5>
                        </th>
                        <th scope="col">
                            <h5 class="color-black font-15 mb-0">{{__('Total')}}</h5>
                        </th>
                        <th scope="col">
                            <h5 class="color-black font-15 mb-0">
                                {{__('Items')}}
                            </h5>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($user->orders as $order)
                        <tr>
                            <td>
                                {{$order->created_at->format('d/m/Y')}}
                            </td>
                            <td>
                                <a href="{{route('admin.orders',['q'=>$order->order_token])}}" target="_blakn">
                                    <strong>
                                        {{$order->order_token}}
                                    </strong>
                                </a>
                            </td>
                            <td>{{$order->shipping_cost}}</td>
                            <td>{{$order->city->name}}</td>
                            <td>{{$order->grand_total}}</td>
                            <td>
                                <button href="#"
                                        data-bs-toggle="offcanvas"
                                        data-bs-target="#order_items_{{$user->id}}"
                                        hx-post="{{route('customer.orderitems.htmx')}}"
                                        hx-vals='{"_token": "{{csrf_token()}}","order_id":"{{$order->id}}"}'
                                        hx-target="#order_target_{{$user->id}}"
                                        class="btn btn-full btn-s font-900  rounded-sm shadow-l bg-highlight  mb-1 pt-2 pb-2">
                                    {{__('Order Items')}}
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center gap-2 mt-2">
                <button type="button" data-bs-dismiss="offcanvas" class="btn btn-full bg-highlight shadow-bg shadow-bg-s">
                    დახურვა
                </button>
            </div>
        </div>
    </div>
</div>
