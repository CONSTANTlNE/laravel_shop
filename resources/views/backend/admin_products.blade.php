@extends('frontend.components.layout')

@section('admin-products-all')

    <style>
        /* Thicker horizontal scrollbar for the admin products table only */
        .table-x-scroll {
            overflow-x: auto;
            overflow-y: hidden;
            scrollbar-gutter: stable both-edges;
            /* Firefox */
            scrollbar-width: auto;
        }

        /* WebKit browsers (Chrome, Edge, Safari) */
        .table-x-scroll::-webkit-scrollbar {
            display: initial !important; /* override global hide */
            height: 14px; /* thickness */
        }

        .table-x-scroll::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.08);
            border-radius: 8px;
        }

        .table-x-scroll::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.40);
            border-radius: 8px;
            border: 3px solid transparent; /* creates a "pill" look */
            background-clip: content-box;
        }

        .table-x-scroll:hover::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.55);
        }

    </style>

    <div class="card overflow-visible card-style m-0 mb-3">
        <div class="content mb-0">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">{{__('Products')}} {{$count}}</h4>
                <form action="{{route('product.export')}}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="fa fa-file-excel"></i> {{__('Export to Excel')}}
                    </button>
                </form>
            </div>

            {{-- Filters --}}

            @include('backend.components.product_filter')

            <div class="table-responsive table-x-scroll">
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
                        <th scope="col" class="text-center">
                            <a href="{{  $sortLink('removed_from_store') }}"
                               class="text-decoration-none  text-center">{{__('Removed')}} {{  $sortIcon('removed_from_store') }}</a>
                        </th>
                        <th scope="col">
                            <a href="{{  $sortLink('featured') }}"
                               class="text-decoration-none  text-center">{{__('Featured ')}} {{  $sortIcon('featured') }}</a>
                        </th>
                        <th scope="col">
                            <a href="{{  $sortLink('show_in_main') }}"
                               class="text-decoration-none  text-center">{{__('On Main ')}} {{  $sortIcon('show_in_main') }}</a>
                        </th>
                        <th scope="col">
                            <a href="{{  $sortLink('is_present') }}"
                               class="text-decoration-none  text-center">{{__('Present')}} {{  $sortIcon('is_present') }}</a>
                        </th>
                        <th scope="col" class="text-center ">
                            {{__('Discount')}}
                        </th>
                        <th scope="col" class="text-center">
                            {{__('Coupon')}}
                        </th>
                        <th scope="col">{{__('Page')}}</th>
                        <th scope="col" class="text-center">{{__('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td class="text-center align-middle">{{$product->created_at->format('d/m/Y')}}</td>
                            <td class="text-center align-middle">{{$product->sku}}</td>
                            <td class="text-center align-middle">{{$product->name}}</td>
                            {{-- category--}}
                            <td class="text-center align-middle">
                                <a href="{{route('admin.products.all',['category_id'=>$product->category->id])}}">
                                    {{$product->category->name}}
                                </a>
                            </td>
                            {{-- subcategory--}}
                            <td class="text-center align-middle">
                                <a href="{{route('admin.products.all',['subcategory_id'=>$product->subcategory?->id])}}">
                                    {{$product->subcategory?->name}}
                                </a>
                            </td>
                            {{-- product images--}}
                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center">
                                    @include('backend.components.modals.product_images')
                                </div>
                                <div class="d-flex justify-content-center">
                                    @include('backend.components.modals.product_add_images_modal')
                                </div>
                            </td>
                            {{-- stock update modal --}}
                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center">
                                    @include('backend.components.modals.product_stock_update')
                                </div>
                            </td>
                            {{-- price update and price history--}}
                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center">
                                    @include('backend.components.modals.product_price_update')
                                </div>
                                <div class="d-flex justify-content-center">
                                    @include('backend.components.modals.product_price_history')
                                </div>
                            </td>
                            {{-- toggle in stock out of stock --}}
                            <td class="text-center align-middle">
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
                            {{-- remove/hide product from shop --}}
                            <td class="text-center align-middle">
                                <form action="{{route('product.removed')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$product->id}}">

                                    <div class="form-switch ios-switch switch-red switch-l">
                                        <input type="checkbox" class="ios-input"
                                               id="removed_{{$product->slug}}"
                                               @checked($product->removed_from_store==1)
                                               onchange="this.form.submit()">
                                        <label class="custom-control-label"
                                               for="removed_{{$product->slug}}"></label>
                                    </div>
                                </form>
                            </td>
                            {{-- show in featured products --}}
                            <td class="text-center align-middle">
                                <form action="{{route('product.featured')}}"

                                      method="post">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$product->id}}">

                                    <div class="form-switch ios-switch switch-green switch-l">
                                        <input type="checkbox" class="ios-input"
                                               id="featured_{{$product->slug}}"
                                               @checked($product->featured==1)
                                               {{--                                               onchange="this.form.submit()"--}}
                                               hx-post="{{route('product.featured')}}"
                                               hx-target="#htmx_messages"
                                        >
                                        <label class="custom-control-label"
                                               for="featured_{{$product->slug}}"></label>
                                    </div>
                                </form>
                            </td>
                            {{-- show on main in categories --}}
                            <td class="text-center align-middle">
                                <form action="{{route('product.onmain')}}"
                                      method="post">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                    <div class="form-switch ios-switch switch-green switch-l">
                                        <input type="checkbox" class="ios-input"
                                               id="onmain_{{$product->slug}}"
                                               @checked($product->show_in_main==1)
                                               hx-post="{{route('product.onmain')}}"
                                               hx-target="#htmx_messages"
                                            {{--                                               onchange="this.form.submit()"--}}
                                        >
                                        <label class="custom-control-label"
                                               for="onmain_{{$product->slug}}"></label>
                                    </div>
                                </form>
                            </td>
                            {{-- is_present , apply present and for_sale  --}}
                            <td class="text-center align-middle">
                                @if($product->presents->isEmpty())
                                    <form class="d-flex justify-content-center mb-1"
                                          action="{{route('product.is_present')}}"
                                          method="post">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                        <div class="form-switch ios-switch switch-green switch-l">
                                            <input type="checkbox" class="ios-input"
                                                   id="ispresent_{{$product->slug}}"
                                                   @checked($product->is_present==1)
                                                   hx-post="{{route('product.is_present')}}"
                                                   hx-target="#htmx_messages"
                                                {{--                                               onchange="this.form.submit()"--}}
                                            >
                                            <label class="custom-control-label"
                                                   for="ispresent_{{$product->slug}}"></label>
                                        </div>
                                    </form>
                                @endif
                                @include('backend.components.modals.product_present_modal')

                                <form class="d-flex justify-content-center mb-1" action="{{route('product.for_sale')}}"
                                      method="post">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                    <button type="button"
                                            class="btn btn-sm @if($product->for_sale) btn-success @else btn-danger @endif"
                                            hx-post="{{route('product.for_sale')}}"
                                            hx-swap="outerHTML"
                                            {{--                                            hx-target="#htmx_messages"--}}
                                            hx-include="[name='product_id']">
                                        <span>{{ $product->for_sale ? __('For Sale') : __('Not For Sale') }}</span>
                                    </button>
                                </form>

                            </td>
                            {{-- apply /remove discounts --}}
                            <td class="text-center align-middle">
                                {{--  discount modal--}}
                                @include('backend.components.modals.product_discount')
                            </td>
                            {{-- apply / remove coupon --}}
                            <td class="text-center align-middle">

                                @include('backend.components.modals.product_coupon')
                            </td>
                            {{-- check product page --}}
                            <td class="text-center align-middle">
                                <a target="_blank"
                                   href="{{route('product.single',['locale'=>app()->getLocale(),'product'=>$product->slug])}}">
                                    Page
                                </a>
                            </td>
                            {{-- delete product  --}}
                            <td class="text-center align-middle">
                                <a href="#" data-bs-toggle="offcanvas" data-bs-target="#delete_product_{{$product->id}}"
                                   class="list-group-item">
                                    <i class="bi bi-trash color-red-dark font-30"></i>
                                </a>
                                <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
                                     style="width:100%;max-width :400px" id="delete_product_{{$product->id}}">
                                    <form class="content" action="{{route('product.delete')}}" method="post">
                                        @csrf
                                        <input type="hidden" value="{{$product->id}}" name="product_id">
                                        <p class="font-24 font-800 mb-3 text-center">
                                            {{__('Are You Sure')}} ?
                                        </p>
                                        <div class="d-flex justify-content-center gap-4">
                                            <button type="button" data-bs-dismiss="offcanvas"
                                                    class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                                                {{__('Cancel')}}
                                            </button>
                                            <button onclick="showOverlay()"
                                                    class="btn btn-full gradient-red shadow-bg shadow-bg-s mt-4">
                                                {{__('Delete')}}
                                            </button>
                                        </div>
                                    </form>
                                </div>

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

    {{--fix scroll position--}}
    <script>
        window.addEventListener('beforeunload', function () {
            localStorage.setItem('scrollPosition', window.scrollY);
        });

        window.addEventListener('load', function () {
            if (localStorage.getItem('scrollPosition') !== null) {
                window.scrollTo(0, parseInt(localStorage.getItem('scrollPosition'), 10));
                localStorage.removeItem('scrollPosition'); // Clear the stored position after use
            }
        });

    </script>
@endsection
