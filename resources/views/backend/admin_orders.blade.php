@extends('frontend.components.layout')

@section('admin-orders')
    @push('css')
        <style>
            /* Make the cart offcanvas clearly show a vertical scrollbar on all major browsers */
            #menu-register {
                /* Keep layout from shifting when scrollbar appears and ensure it’s reserved */
                scrollbar-gutter: stable both-edges;
                /* Firefox visible scrollbar styling */
                scrollbar-width: auto;
                scrollbar-color: rgba(0, 0, 0, 0.45) rgba(0, 0, 0, 0.08);
            }

            /* WebKit-based browsers (Chrome, Edge, Safari, Opera) */
            #menu-register::-webkit-scrollbar {
                width: 10px;
            }

            #menu-register::-webkit-scrollbar-track {
                background: rgba(0, 0, 0, 0.08);
                border-radius: 8px;
            }

            #menu-register::-webkit-scrollbar-thumb {
                background: rgba(0, 0, 0, 0.35);
                border-radius: 8px;
            }

            #menu-register:hover::-webkit-scrollbar-thumb {
                background: rgba(0, 0, 0, 0.55);
            }
        </style>
    @endpush
    <div class="card overflow-visible card-style m-0 mb-3">
        <div class="content mb-0">
            <h4>Orders</h4>
            {{-- Filters --}}
            <form method="GET" class="mb-2">
                <div class="d-flex flex-wrap gap-2 justify-content-center align-items-end mb-3">
                    <div>
                        <label class="d-block small mb-1 text-center">{{__('Per Page')}}</label>
                        <select name="per_page" class="form-select rounded-xs w-auto d-inline"
                                onchange="this.form.submit()">
                            @foreach([10,20, 30, 50, 100] as $size)
                                <option value="{{ $size }}" {{ request('per_page', 20) == $size ? 'selected' : '' }}>
                                    {{ $size }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="d-block small mb-1 text-center">{{__('Delivered')}}</label>
                        <select name="delivery" class="form-select rounded-xs w-auto d-inline"
                                onchange="this.form.submit()">
                            <option value="all" @selected(request('delivery')=='all')>
                                {{__('Choose')}}
                            </option>
                            <option value="true" @selected(request('delivery')=='true')>
                                {{__('Delivered')}}
                            </option>
                            <option value="false" @selected(request('delivery')=='false')>
                                {{__('Pending')}}
                            </option>

                        </select>
                    </div>

                    <div>
                        <label class="d-block small mb-1 text-center">Search</label>
                        <input type="text" name="q" value="{{ request()->query('q') }}"
                               placeholder="Order, Amount, Address, Bank Order"
                               class="form-control rounded-xs"/>
                    </div>

                    <div class="d-flex flex-wrap gap-2 justify-content-center align-items-end">
                        <div>
                            <label class="d-block small mb-1 text-center">Min Price</label>
                            <input type="number" step="0.01" min="0" name="min_price"
                                   value="{{ request()->query('min_price') }}" class="form-control rounded-xs"/>
                        </div>
                        <div>
                            <label class="d-block small mb-1 text-center">Max Price</label>
                            <input type="number" step="0.01" min="0" name="max_price"
                                   value="{{ request()->query('max_price') }}" class="form-control rounded-xs"/>
                        </div>
                    </div>
                    <input type="hidden" name="sort_by"
                           value="{{ request()->query('sort_by', $sortBy ?? 'created_at') }}"/>
                    <input type="hidden" name="sort_dir"
                           value="{{ request()->query('sort_dir', $sortDir ?? 'desc') }}"/>
                </div>
                <div class="d-flex gap-2 justify-content-center align-items-center">
                    <button class="btn btn-sm btn-primary rounded-xs">Apply</button>
                    <a class="btn btn-sm btn-secondary rounded-xs"
                       href="{{ route('admin.orders', ['locale'=>app()->getLocale()]) }}">Reset</a>
                </div>
            </form>

            <div class="table-responsive mt-3">
                <table class="table color-theme mb-2">
                    <thead>
                    @php
                        $currentSortBy = request()->query('sort_by', $sortBy ?? 'created_at');
                        $currentSortDir = strtolower(request()->query('sort_dir', $sortDir ?? 'desc')) === 'asc' ? 'asc' : 'desc';
                        $toggleDir = $currentSortDir === 'asc' ? 'desc' : 'asc';

                        $sortLink = function($col) use ($currentSortBy, $currentSortDir) {
                            $dir = $currentSortBy === $col ? ($currentSortDir === 'asc' ? 'desc' : 'asc') : 'asc';
                            return request()->fullUrlWithQuery(['sort_by'=>$col,'sort_dir'=>$dir]);
                        };

                        $sortIcon = function($col) use ($currentSortBy, $currentSortDir) {
                            if ($currentSortBy !== $col) return '';
                            return $currentSortDir === 'asc' ? '▲' : '▼';
                        };
                    @endphp
                    <tr>
                        <th scope="col" class="text-center">
                            <a href="{{  $sortLink('created_at') }}"
                               class="text-decoration-none">
                                Date {{  $sortIcon('created_at') }}
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href="{{  $sortLink('created_at') }}"
                               class="text-decoration-none">
                                {{__('Customer')}}
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href="{{  $sortLink('name') }}"
                               class="text-decoration-none">Order {{  $sortIcon('name') }}
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href="{{  $sortLink('category_name') }}"
                               class="text-decoration-none">Amount {{  $sortIcon('category_name') }}
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href="{{  $sortLink('category_name') }}"
                               class="text-decoration-none">Address {{  $sortIcon('category_name') }}
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            Bank Order
                        </th>
                        <th scope="col" class="text-center">
                            Products
                        </th>
                        <th scope="col" class="text-center">
                            Presents
                        </th>
                        <th scope="col" class="text-center">
                            Google Map
                        </th>
                        <th scope="col" class="text-center">
                            Waybill
                        </th>
                        <th scope="col" class="text-center">
                            Delivered
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td class="text-center">{{$order->created_at->format('d/m/Y')}}</td>
                            <td class="text-center">
                                {{$order->owner->name}}
                                <br>
                                {{$order->owner->mobile}}
                            </td>
                            <td class="text-center">{{$order->order_token}}</td>
                            <td class="text-center">{{$order->grand_total}}</td>
                            <td class="text-center">{{$order->address}}</td>
                            <td class="text-center">{{$order->bank_order_id}}</td>
                            <td class="text-center">
                                <a href="#" data-bs-toggle="offcanvas"
                                   data-bs-target="#order_products_{{$order->order_token}}"
                                   class="default-link btn btn-m rounded-s gradient-highlight shadow-bg shadow-bg-s px-5 mb-0 ">
                                    {{__('Products')}}
                                </a>
                                @include('backend.components.modals.order_products')
                            </td>
                            <td class="text-center">
                                {{--                                @if($order->presentsRelation?->isNotEmpty())--}}
                                {{--                                    <a href="#" data-bs-toggle="offcanvas"--}}
                                {{--                                       data-bs-target="#order_presents_{{$order->order_token}}"--}}
                                {{--                                       class="default-link btn btn-m rounded-s gradient-highlight shadow-bg shadow-bg-s px-5 mb-0 ">--}}
                                {{--                                        {{__('Presents')}}--}}
                                {{--                                    </a>--}}
                                {{--                                    @include('backend.components.modals.order_presents')--}}
                                {{--                                @endif--}}

                                @if($order->presents!=null)
                                    <a href="#" data-bs-toggle="offcanvas"
                                       data-bs-target="#order_presents_{{$order->order_token}}"
                                       class="default-link btn btn-m rounded-s gradient-highlight shadow-bg shadow-bg-s px-5 mb-0 ">
                                        {{__('Presents')}}
                                    </a>
                                    @include('backend.components.modals.order_presents')
                                @endif
                            </td>
                            <td class="text-center">
                                @if($order->google_map!=null)
                                    <a href="{{$order->google_map}}" target="_blank">Google Map</a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="text-center">
                                @php
                                    $finished=$order->waybill?->is_finished
                                @endphp
                                @if($order->waybill == null)
                                    <form action="{{route('waybill.with.transport')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{$order->id}}">

                                        <button type="submit"
                                                class="default-link btn btn-m rounded-s gradient-highlight shadow-bg shadow-bg-s px-5 mb-0 ">
                                            Waybill
                                        </button>
                                    </form>
                                @endif
                                @if($order->waybill !=null && $order->waybill->status==0)
                                    <form action="{{route('waybill.finish')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{$order->id}}">
                                        <p class="mb-0">{{$order->waybill->waybill_number}}</p>
                                        @if(!$finished)
                                            <button type="submit"
                                                    class="default-link btn btn-m rounded-s gradient-blue shadow-bg shadow-bg-s px-5 mb-0 ">
                                                Finish
                                            </button>
                                        @else
                                            <button type="button"
                                                    class="default-link btn btn-m rounded-s gradient-green shadow-bg shadow-bg-s px-5 mb-0 ">
                                                Finished
                                            </button>
                                        @endif
                                    </form>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    <form action="{{route('admin.orders.delivery')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{$order->id}}">

                                        <div class="form-switch ios-switch switch-green switch-l">
                                            <input type="checkbox" class="ios-input"
                                                   id="order_delivered_{{$order->id}}"
                                                   @checked($order->is_delivered==1)
                                                   onchange="this.form.submit()">
                                            <label class="custom-control-label"
                                                   for="order_delivered_{{$order->id}}"></label>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                @if(method_exists($orders, 'links'))
                    <div class="d-flex justify-content-center align-items-center gap-4 mt-3">
                        {{ $orders->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
