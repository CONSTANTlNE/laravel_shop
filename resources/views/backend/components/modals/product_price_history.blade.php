<button href="#"
        data-bs-toggle="offcanvas"
        data-bs-target="#price_history_{{$product->id}}"
        class="btn btn-full btn-s font-900  rounded-sm shadow-l {{$product->discounted==1 ? 'bg-green-dark' : 'bg-blue-dark' }}  mb-1 pt-2 pb-2">
    {{__('Price History')}}
</button>

<div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
     style="width:100%;max-width :400px" id="price_history_{{$product->id}}">
    <div class="content" style="overflow: hidden">
        <p class="font-18 font-800 mb-3">{{__('Price History')}}: {{$product->name}}</p>
        <style>
            /* Prevent wrapping inside the price history table (scoped to this modal) */
            #price_history_{{$product->id}} table th,
            #price_history_{{$product->id}} table td {
                white-space: nowrap;
            }
        </style>
        <table class="table color-theme mb-2" style="table-layout: fixed; width: 100%;">
            <thead>
            <tr>
                <th style="width: 90px!important;" scope="col">{{__('Date')}}</th>
                <th scope="col">{{__('Price')}}</th>
                <th style="width: 75px!important;" scope="col">{{__('Discount')}} %</th>
                <th scope="col" style="width: min-content">{{__('Reason')}}</th>
                <th style="width: 90px!important;" scope="col">{{__('Updated By')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($product->price_history as $history)
                <tr>
                    <td style="width: 90px!important;">{{ $history['update_date'] ?? '-' }}</td>
                    <td>{{ $history['price'] ?? '-' }}</td>
                    <td>
                        {{ $history['discount%'] ?? '' }}
                        {{--                                                        @if(!empty($history['discount_id']))--}}
                        {{--                                                            (ID: {{ $history['discount_id'] }})--}}
                        {{--                                                        @endif--}}
                    </td>
                    <td>{{ $history['reason'] ?? '-' }}</td>
                    <td>
                        {{--                                                        @if(!empty($history['user_id']))--}}
                        {{--                                                            {{ \App\Models\Admin::find($history['user_id'])->name ?? 'Unknown' }}--}}
                        {{--                                                        @endif--}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            <button  data-bs-dismiss="offcanvas" class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                {{__('Close')}}
            </button>
        </div>
    </div>

</div>
