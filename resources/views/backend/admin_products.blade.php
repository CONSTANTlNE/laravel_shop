@extends('frontend.components.layout')

@section('admin-products-all')

    <div class="card overflow-visible card-style m-0 mb-3">
        <div class="content mb-0">
            <h4>{{_('Products')}} {{$count}}</h4>

            {{-- Filters --}}
            @include('backend.components.product_filter')

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
                               class="text-decoration-none text-center">{{__('Created')}} {{  $sortIcon('created_at') }}</a>
                        </th>
                        <th scope="col" class="text-center">SKU</th>
                        <th scope="col" class="text-center">
                            <a href="{{  $sortLink('name') }}"
                               class="text-decoration-none  text-center">{{__('Name')}} {{  $sortIcon('name') }}</a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href="{{  $sortLink('category_name') }}"
                               class="text-decoration-none  text-center">{{__('Category')}} {{  $sortIcon('category_name') }}</a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href="{{  $sortLink('subcategory_name') }}"
                               class="text-decoration-none  text-center">{{__('Subcategory')}} {{  $sortIcon('subcategory_name') }}</a>
                        </th>
                        <th class="text-center">
                            {{__('Images')}}
                        </th>
                        <th scope="col">
                            <a href="{{  $sortLink('stock') }}"
                               class="text-decoration-none  text-center">{{__('Stock')}} {{  $sortIcon('stock') }}</a>
                        </th>
                        <th scope="col">
                            <a href="{{  $sortLink('price') }}"
                               class="text-decoration-none  text-center">{{__('Price')}} {{  $sortIcon('price') }}</a>
                        </th>
                        <th scope="col">
                            <a href="{{  $sortLink('in_stock') }}"
                               class="text-decoration-none  text-center">{{__('Status')}} {{  $sortIcon('in_stock') }}</a>
                        </th>
                        <th scope="col">
                            <a href="{{  $sortLink('show_in_main') }}"
                               class="text-decoration-none  text-center">{{__('On Main ')}} {{  $sortIcon('show_in_main') }}</a>
                        </th>
                        <th scope="col">
                            <a href="{{  $sortLink('show_in_main') }}"
                               class="text-decoration-none  text-center">{{__('Featured')}} {{  $sortIcon('featured') }}</a>
                        </th>
                        <th scope="col" class="text-center ">
                            {{__('Discount')}}
                        </th>
                        <th scope="col" class="text-center">
                            {{__('Coupon')}}
                        </th>
                        <th scope="col">{{__('Page')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td  class="text-center align-middle">{{$product->created_at->format('d/m/Y')}}</td>
                            <td  class="text-center align-middle">{{$product->sku}}</td>
                            <td class="text-center align-middle">{{$product->name}}</td>
                            <td class="text-center align-middle">{{$product->category->name}}</td>
                            <td class="text-center align-middle">{{$product->subcategory?->name}}</td>
                            <td  class="text-center align-middle">
                                <div class="d-flex justify-content-center">
                                    @include('backend.components.modals.product_images')
                                </div>
                                <div class="d-flex justify-content-center">
                                    @include('backend.components.modals.product_add_images_modal')
                                </div>
                            </td>
                            <td  class="text-center align-middle">{{$product->stock}}</td>
                            <td  class="text-center align-middle">
                                {{--  price and price history --}}
                                @include('backend.components.modals.product_price_history')
                            </td>
                            <td  class="text-center align-middle">
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
                            <td  class="text-center align-middle">
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
                            <td  class="text-center align-middle">
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
                            <td  class="text-center align-middle">
                                {{--  discount modal--}}
                                @include('backend.components.modals.product_discount')
                            </td>
                            <td  class="text-center align-middle">
                                {{-- apply / remove coupon --}}
                                @include('backend.components.modals.product_coupon')
                            </td>
                            <td  class="text-center align-middle">
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
