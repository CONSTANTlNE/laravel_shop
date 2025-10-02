@extends('frontend.components.layout')

@section('admin-products-all')

    <div class="card overflow-visible card-style m-0 mb-3">
        <div class="content mb-0">
            <h4>Products {{$count}}</h4>

            {{-- Filters --}}
            <form method="GET" class="mb-2">
                <div class="d-flex flex-wrap gap-2 justify-content-center align-items-end mb-3">
                    <div>
                        <label class="d-block small mb-1 text-center">Per PAge</label>
                        <select name="per_page" class="form-select rounded-xs w-auto d-inline"
                                onchange="this.form.submit()">
                            @foreach([10,20, 30, 50, 100] as $size)
                                <option value="{{ $size }}" {{ request('per_page', 20) == $size ? 'selected' : '' }}>
                                    {{ $size }}
                                </option>
                            @endforeach
                            <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>
                                All
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="d-block small mb-1 text-center">Category</label>
                        <select name="category_id" class="form-select rounded-xs" onchange="this.form.submit()">
                            <option value="">All</option>
                            @isset($categories)
                                @foreach($categories as $cat)
                                    <option
                                        value="{{ $cat->id }}" {{ (string)request()->query('category_id') === (string)$cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div>
                        <label class="d-block small mb-1 text-center">Subcategory</label>
                        <select name="subcategory_id" class="form-select rounded-xs">
                            <option value="">All</option>
                            @isset($subcategories)
                                @php $selectedCat = request()->query('category_id'); @endphp
                                @foreach($subcategories as $sub)
                                    @if(!$selectedCat || (string)$sub->category_id === (string)$selectedCat)
                                        <option
                                            value="{{ $sub->id }}" {{ (string)request()->query('subcategory_id') === (string)$sub->id ? 'selected' : '' }}>
                                            {{ $sub->name }}
                                        </option>
                                    @endif
                                @endforeach
                            @endisset
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
                <div class="d-flex gap-2 justify-content-center align-items-center">
                    <button class="btn btn-sm btn-primary rounded-xs">Apply</button>
                    <a class="btn btn-sm btn-secondary rounded-xs"
                       href="{{ route('admin.products.all', ['locale'=>app()->getLocale()]) }}">Reset</a>
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
                            <a href="{{  $sortLink('created_at') }}"
                               class="text-decoration-none">Created {{  $sortIcon('created_at') }}</a>
                        </th>
                        <th scope="col">SKU</th>
                        <th scope="col">
                            <a href="{{  $sortLink('name') }}"
                               class="text-decoration-none">Name {{  $sortIcon('name') }}</a>
                        </th>
                        <th scope="col">
                            <a href="{{  $sortLink('category_name') }}"
                               class="text-decoration-none">Category {{  $sortIcon('category_name') }}</a>
                        </th>
                        <th scope="col">
                            <a href="{{  $sortLink('subcategory_name') }}"
                               class="text-decoration-none">Subcategory {{  $sortIcon('subcategory_name') }}</a>
                        </th>
                        <th scope="col">
                            <a href="{{  $sortLink('stock') }}"
                               class="text-decoration-none">Stock {{  $sortIcon('stock') }}</a>
                        </th>
                        <th scope="col">
                            <a href="{{  $sortLink('price') }}"
                               class="text-decoration-none">Price {{  $sortIcon('price') }}</a>
                        </th>
                        <th scope="col">
                            <a href="{{  $sortLink('in_stock') }}"
                               class="text-decoration-none">Status {{  $sortIcon('in_stock') }}</a>
                        </th>
                        <th scope="col">
                            <a href="{{  $sortLink('show_in_main') }}"
                               class="text-decoration-none">On Main {{  $sortIcon('show_in_main') }}</a>
                        </th>
                        <th scope="col">
                            <a href="{{  $sortLink('show_in_main') }}"
                               class="text-decoration-none">Featured {{  $sortIcon('featured') }}</a>
                        </th>
                        <th scope="col">Discount</th>
                        <th scope="col">Page</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{$product->created_at->format('d/m/Y')}}</td>
                            <td>{{$product->sku}}</td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->category->name}}</td>
                            <td>{{$product->subcategory?->name}}</td>
                            <td>{{$product->stock}}</td>
                            <td>
                                {{--  price and price history --}}
                                <button href="#"
                                        data-bs-toggle="offcanvas"
                                        data-bs-target="#price_history_{{$product->id}}"
                                        class="btn btn-full btn-s font-900  rounded-sm shadow-l {{$product->discounted==1 ? 'bg-green-dark' : 'bg-blue-dark' }}  mb-1 pt-2 pb-2">
                                    {{$product->price}}
                                </button>

                                <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
                                     style="width:100%;max-width :400px" id="price_history_{{$product->id}}">
                                    <form class="content" action="" method="post"
                                          style="overflow: hidden"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="{{$product->id}}" name="product_id">
                                        <p class="font-18 font-800 mb-3">Price History {{$product->name}}</p>
                                        <table class="table color-theme mb-2" style="table-layout: fixed; width: 100%;">
                                            <thead>
                                            <tr>
                                                <th style="width: 90px!important;" scope="col">Date</th>
                                                <th scope="col">Price</th>
                                                <th style="width: 75px!important;" scope="col">Discount</th>
                                                <th scope="col">Reason</th>
                                                <th style="width: 90px!important;" scope="col">Updated By</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($product->price_history as $history)
                                                <tr>
                                                    <td style="width: 90px!important;">{{ $history['update_date'] ?? '-' }}</td>
                                                    <td>{{ $history['price'] ?? '-' }}</td>
                                                    <td>
                                                        {{ $history['discount%'] ?? '' }}%
                                                        {{--                                                        @if(!empty($history['discount_id']))--}}
                                                        {{--                                                            (ID: {{ $history['discount_id'] }})--}}
                                                        {{--                                                        @endif--}}
                                                    </td>
                                                    <td>{{ $history['reason'] ?? '-' }}</td>
                                                    <td>
                                                        @if(!empty($history['user_id']))
                                                            {{ \App\Models\Admin::find($history['user_id'])->name ?? 'Unknown' }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <div class="d-flex justify-content-center">
                                            <button class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                                                Apply
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </td>
                            <td>
                                <form action="{{route('product.in-stock')}}" method="post">
                                    @csrf
                                    <input type="hidden" value="{{$product->id}}" name="product_id">
                                    <button style="all: unset;cursor:pointer">
                                        @if($product->in_stock==1)
                                            <span class="color-green-dark d-block font-11 font-600">In Stock</span>
                                        @else
                                            <span class="color-red-dark d-block font-11 font-600">Out of Stock</span>
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form action="{{route('product.main.update')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$product->id}}">

                                    <div class="form-switch ios-switch switch-green switch-l">
                                        <input type="checkbox" class="ios-input"
                                               id="switch-4c{{$product->slug}}"
                                               @checked($product->show_in_main==1)
                                               onchange="this.form.submit()">
                                        <label class="custom-control-label"
                                               for="switch-4c{{$product->slug}}"></label>
                                    </div>
                                </form>
                            </td>
                            <td>
                                <form action="{{route('product.featured')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$product->id}}">

                                    <div class="form-switch ios-switch switch-green switch-l">
                                        <input type="checkbox" class="ios-input"
                                               id="featured_{{$product->slug}}"
                                               @checked($product->featured==1)
                                               onchange="this.form.submit()">
                                        <label class="custom-control-label"
                                               for="featured_{{$product->slug}}"></label>
                                    </div>
                                </form>
                            </td>
                            <td>
                                <button href="#"
                                        data-bs-toggle="offcanvas"
                                        data-bs-target="#apply_discount_{{$product->id}}"
                                        class="btn btn-full btn-s font-900  rounded-sm shadow-l {{$product->discounted==1 ? 'bg-green-dark' : 'bg-blue-dark' }}  mb-1 pt-2 pb-2">
                                    @if($product->discounted==1)
                                        Discounted
                                    @else
                                        Discount
                                    @endif
                                </button>

                                <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
                                     style="width:100%;max-width :400px" id="apply_discount_{{$product->id}}">
                                    @if($product->discounted==1)
                                        {{--  remove discount --}}
                                        <form class="content" action="{{route('discount.remove.product')}}"
                                              method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" value="{{$product->id}}" name="product_id">
                                            <input type="hidden" value="{{$product->discount->id}}" name="discount_id">
                                            <p class=" font-18 font-800 mb-3">Remove Discount {{$product->name}}</p>
                                            <div class="d-flex justify-content-center form-check form-check-custom">
                                                <input class="form-check-input" name="increase_price" @checked($product->discount->increase_price==1)
                                                       type="checkbox" value="" id="increase_price{{$product->id}}">
                                                <label class="form-check-label" for="increase_price{{$product->id}}">
                                                    Increase Price after deadline
                                                </label>
                                                <i class="is-checked color-green-dark bi bi-check-square" style="left:100px"></i>
                                                <i class="is-unchecked color-red-dark bi bi-x-square" style="left:100px"></i>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <button class="btn btn-full gradient-red shadow-bg shadow-bg-s mt-4">
                                                    Remove Discount
                                                </button>
                                            </div>
                                        </form>
                                    @else
                                        {{-- apply discount --}}
                                        <form class="content" action="{{route('discount.apply.product')}}" method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" value="{{$product->id}}" name="product_id">
                                            <p class="font-18 font-800 mb-3">Apply Discount to {{$product->name}}</p>

                                            @foreach($discounts as $discount)
                                                <div class="form-check form-check-custom">
                                                    <input class="form-check-input" type="checkbox" name="discount_id"
                                                           value="{{$discount->id}}"
                                                           id="c2{{$discount->id}}{{$product->id}}">
                                                    <label class="form-check-label"
                                                           for="c2{{$discount->id}}{{$product->id}}">
                                                        {{$discount->discount_percentage}}% Valid
                                                        till: {{$discount->valid_till}}
                                                    </label>
                                                    <i class="is-checked color-green-dark bi bi-check-circle"></i>
                                                    <i class="is-unchecked color-highlight bi bi-circle"></i>
                                                </div>
                                            @endforeach

                                            <div class="d-flex justify-content-center">
                                                <button class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                                                    Apply
                                                </button>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </td>

                            <td>
                                <a target="_blank"
                                   href="{{route('product.single',['locale'=>app()->getLocale(),'product'=>$product->slug])}}">
                                    Page
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if(method_exists($products, 'links'))
                    <div class="d-flex justify-content-center align-items-center gap-4 mt-3">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
