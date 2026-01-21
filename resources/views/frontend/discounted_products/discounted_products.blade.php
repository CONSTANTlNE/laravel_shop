@extends('frontend.components.layout')

@section('front-discounted-products')

    {{--  categories grid--}}
    <div class="card card-style mx-0">
        <div class="content">
            <h2 class="text-center mb-3">
                {{__('Discounts')}}
            </h2>
                {{--  sort and filter for products--}}
                <div class="d-flex justify-content-center gap-3 mb-3">
                    {{-- Sort toggle (preserves current min/max) --}}
                    @php
                        $currentSort = strtolower(request()->query('sort', 'asc')) === 'desc' ? 'desc' : 'asc';
                        $nextSort = $currentSort === 'asc' ? 'desc' : 'asc';
                        $minQ = request()->query('min_price');
                        $maxQ = request()->query('max_price');
                    @endphp
                    <form method="GET" class="d-flex align-items-center">
                        <input type="hidden" name="sort" value="{{ $nextSort }}">
                        @if(!is_null($minQ))
                            <input type="hidden" name="min_price" value="{{ $minQ }}">
                        @endif
                        @if(!is_null($maxQ))
                            <input type="hidden" name="max_price" value="{{ $maxQ }}">
                        @endif
                        <button style="all: unset;cursor:pointer" class="d-flex"
                                title="Sort by price ({{ $nextSort }})">
                            <i class="bi bi-arrow-down font-20 {{ $currentSort==='desc' ? 'color-blue-dark' : '' }}"></i>
                            <i class="bi bi-arrow-up font-20 {{ $currentSort==='asc' ? 'color-blue-dark' : '' }}"></i>
                        </button>
                    </form>

                    {{-- Filter form (preserves current sort) --}}

                    <form method="GET" class="d-flex gap-2 align-items-center">
                        <input type="hidden" name="sort" value="{{ $currentSort }}">
                        <input type="number" name="min_price" class="form-control rounded-xs" min="0" step="0.01"
                               placeholder="{{__('Min Price')}}" value="{{ request()->query('min_price') }}">
                        <input type="number" name="max_price" class="form-control rounded-xs" min="0" step="0.01"
                               placeholder="{{__('Max Price')}}" value="{{ request()->query('max_price') }}">
                        <button style="all: unset;cursor:pointer" title="Apply">
                            <i class="bi bi-funnel-fill font-20"></i>
                        </button>
                        @if(request()->has('min_price') || request()->has('max_price'))
                            <a href="?sort={{ $currentSort }}" class="ms-2" title="Clear filters">
                                <i class="bi bi-x-circle font-25 color-red-dark"></i>
                            </a>
                        @endif
                    </form>
                </div>
            <div class="row mb-0 justify-content-center">
                @foreach($products as $product)
                    @php
                        $mainImage = $product->media->where('main',1)->first();
                         $just_image=$product->media->first();
                    @endphp
                    <div  class="col-6 col-sm-6 col-md-4 col-lg-3 text-center mb-3 d-flex flex-column justify-content-between " >
                        @include('frontend.components.single_product_component')
                    </div>
                @endforeach

            </div>
            <div class="d-flex justify-content-center align-items-center gap-4 mt-3">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

@endsection
