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
            <h4>Carts</h4>
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
                            <a href="{{  $sortLink('product_total') }}"
                               class="text-decoration-none">
                                {{__('Total')}}
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href="{{  $sortLink('name') }}"
                               class="text-decoration-none">Order {{  $sortIcon('name') }}
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            {{__('Products')}}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($carts as $cart)
                        <tr>
                            <td class="text-center">{{$cart->created_at->format('d/m/Y')}}</td>
                            <td class="text-center">
                                {{$cart->product_total}}
                            </td>
                            <td class="text-center">
                                <p class="mb-1">{{$cart->owner?->name}}</p>
                                <p onclick="copy(this)">{{$cart->owner?->mobile}}</p>
                            </td>
                            <td class="text-center">
                                <a href="#" data-bs-toggle="offcanvas"
                                   hx-get="{{route('admin.cart.products')}}"
                                   hx-vals='{"cart_token": "{{$cart->cart_token}}"}'
                                   hx-target="#cart_products_{{$cart->cart_token}}"
                                   data-bs-target="#cart_products_{{$cart->cart_token}}"
                                   class="default-link btn btn-m rounded-s gradient-highlight shadow-bg shadow-bg-s px-5 mb-0 ">
                                    {{__('Products')}}
                                </a>
                                @include('backend.components.modals.cart_products')
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                @if(method_exists($carts, 'links'))
                    <div class="d-flex justify-content-center align-items-center gap-4 mt-3">
                        {{ $carts->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
