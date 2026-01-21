@extends('frontend.components.layout')

@section('customer-orders')
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
            <h4 class="text-center">{{__('Purchases')}}</h4>
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
                            <a href="{{ $sortLink('created_at') }}"
                               class="text-decoration-none d-inline-flex align-items-center gap-1"
                               style="min-width: max-content; white-space: nowrap;">
                                {{ __('Date') }} {!! $sortIcon('created_at') !!}
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href="{{  $sortLink('name') }}"   style="min-width: max-content; white-space: nowrap;"
                               class="text-decoration-none d-inline-flex align-items-center gap-1">{{__('Order No')}} {{  $sortIcon('name') }}
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href="{{  $sortLink('category_name') }}"   style="min-width: max-content; white-space: nowrap;"
                               class="text-decoration-none d-inline-flex align-items-center gap-1">{{__('Amount')}} {{  $sortIcon('category_name') }}
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href="{{  $sortLink('category_name') }}"   style="min-width: max-content; white-space: nowrap;"
                               class="text-decoration-none d-inline-flex align-items-center gap-1">{{__('Address')}} {{  $sortIcon('category_name') }}
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            {{__('Products')}}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td class="text-center">{{$order->created_at->format('d/m/Y')}}</td>
                            <td class="text-center">{{$order->order_token}}</td>
                            <td class="text-center">{{$order->grand_total}}</td>
                            <td class="text-center">{{$order->address}}</td>
                            <td class="text-center">
                                <a  href="#" data-bs-toggle="offcanvas"
                                    data-bs-target="#order_products_{{$order->order_token}}"
                                    class="default-link btn btn-m rounded-s gradient-highlight shadow-bg shadow-bg-s px-5 mb-0 ">
                                    {{__('Products')}}
                                </a>
                                @include('frontend.components.modals.order_products_customer')
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
