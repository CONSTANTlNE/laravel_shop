@extends('frontend.components.layout')

@section('admin-products-all')

    <div class="card overflow-visible card-style m-0 mb-3">
        <div class="content mb-0">
            <h4>{{__('Sold Products')}}</h4>

            {{-- Filters (same as all_products) --}}
            <form method="GET" class="mb-2">
                <div class="d-flex flex-wrap gap-2 justify-content-center align-items-end mb-3">
                    <div>
                        <label class="d-block small mb-1 text-center">Per Page</label>
                        <select name="per_page" class="form-select rounded-xs w-auto d-inline"
                                onchange="this.form.submit()">
                            @foreach([10,20, 30, 50, 100] as $size)
                                <option value="{{ $size }}" {{ request('per_page', 20) == $size ? 'selected' : '' }}>
                                    {{ $size }}
                                </option>
                            @endforeach
                        </select>
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
                <div class="d-flex flex-wrap gap-2 justify-content-center align-items-center mb-2">
                    <div class="flex-grow-1" style="min-width: 260px; max-width: 520px;">
                        <label class="d-block small mb-1 text-center">Search</label>
                        <input type="text" name="q" value="{{ request()->query('q') }}" class="form-control rounded-xs"
                               placeholder="Search by product name, SKU, slug, order token..." />
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-2 justify-content-center align-items-center mb-2">
                    <div>
                        <label class="d-block small mb-1 text-center">Date From</label>
                        <input type="date" name="date_from" value="{{ request()->query('date_from') }}" class="form-control rounded-xs" />
                    </div>
                    <div>
                        <label class="d-block small mb-1 text-center">Date To</label>
                        <input type="date" name="date_to" value="{{ request()->query('date_to') }}" class="form-control rounded-xs" />
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center align-items-center">
                    <button class="btn btn-sm btn-primary rounded-xs">Apply</button>
                    @php $reset = $resetRoute ?? route('admin.products.sold', ['locale'=>app()->getLocale()]); @endphp
                    <a class="btn btn-sm btn-secondary rounded-xs" href="{{ $reset }}">Reset</a>
                </div>
            </form>


            <div class="table-responsive">
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
                        <th scope="col">
                            <a href="{{  $sortLink('created_at') }}" class="text-decoration-none">
                                {{__('Sold At')}} {{  $sortIcon('created_at') }}</a>
                        </th>
                        <th scope="col">{{__('Order')}}</th>
                        <th scope="col">
                            <a href="{{  $sortLink('product_name') }}"
                               class="text-decoration-none">SKU </a>
                        </th>
                        <th scope="col">
                            <a href="{{  $sortLink('product_name') }}"
                               class="text-decoration-none">{{__('Name')}} {{  $sortIcon('product_name') }}</a>
                        </th>
                        <th>{{ __('Image') }}</th>
                        <th scope="col">
                            <a href="{{  $sortLink('quantity') }}"
                               class="text-decoration-none">{{__('QTY')}} {{  $sortIcon('quantity') }}</a>
                        </th>
                        <th scope="col">
                            <a href="{{  $sortLink('total_price') }}"
                               class="text-decoration-none">Total Price {{  $sortIcon('total_price') }}</a>
                        </th>
                        <th scope="col">
                            <a href="{{  $sortLink('product_price') }}" class="text-decoration-none">
                                {{__('Unit Price')}} {{  $sortIcon('product_price') }}</a>
                        </th>
                        <th scope="col">{{__('Page')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order_items as $item)
                        <tr>
                            <td>{{$item->created_at?->format('d/m/Y')}}</td>
                            <td>
                                <a target="_blank" href="{{route('admin.orders',['q'=> $item->order->order_token])}}">
                                    {{$item->order->order_token}}
                                </a>

                            </td>
                            <td>{{$item->product?->sku}}</td>
                            <td>{{$item->product?->name}}</td>
                            <td>
                                <div class="">
                                    <img
                                        @if($item->product && $item->product->getMedia('product_image')->where('main',1)->first())
                                            src="{{ $item->product->getMedia('product_image')->where('main',1)->first()->getUrl() }}"
                                        @elseif($item->product && $item->product->getMedia('product_image')->first())
                                            src="{{ $item->product->getMedia('product_image')->first()->getUrl() }}"
                                        @endif
                                        class="rounded-m shadow-xl" width="100">
                                </div>
                            </td>
                            <td>{{$item->quantity}}</td>
                            <td>{{$item->product_price}}</td>
                            <td>{{ number_format(($item->product_price ?? 0) * ($item->quantity ?? 0), 2) }}</td>
                            <td>
                                @if($item->product)
                                    <a target="_blank"
                                       href="{{ route('product.single', ['locale'=>app()->getLocale(),'product'=>$item->product->slug]) }}">
                                        Page
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if(method_exists($order_items, 'links'))
                    <div class="d-flex justify-content-center align-items-center gap-4 mt-3">
                        {{ $order_items->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
