@extends('frontend.components.layout')

@section('admin-categories-all')

    <div class="card overflow-visible card-style m-0 mb-3">
        <div class="content mb-0">
            <div id="js-check">JavaScript is enabled ✅</div>
            <noscript>
                <div style="color: red;">⚠️ JavaScript is disabled in your browser!</div>
            </noscript>
            <h4>Categories {{$count}} </h4>

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
                        <select name="subcategory_id" class="form-select rounded-xs" onchange="this.form.submit()">
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
                    <input type="hidden" name="sort_by"
                           value="{{ request()->query('sort_by', $sortBy ?? 'created_at') }}"/>
                    <input type="hidden" name="sort_dir"
                           value="{{ request()->query('sort_dir', $sortDir ?? 'desc') }}"/>
                </div>
                <div class="d-flex gap-2 justify-content-center align-items-center">
                    {{--                    <button class="btn btn-sm btn-primary rounded-xs">Apply</button>--}}
                    <a class="btn btn-sm btn-secondary rounded-xs"
                       href="{{ route('admin.categories.all', ['locale'=>app()->getLocale()]) }}">
                        Reset
                    </a>
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
                        @if(auth('admin')->user()->email==='gmta.constantine@gmail.com')
                            <th>
                                ID
                            </th>
                        @endif
                        <th scope="col">
                            <a href="{{  $sortLink('created_at') }}"
                               class="text-decoration-none">
                                Created {{  $sortIcon('created_at') }}
                            </a>
                        </th>
                        <th scope="col">
                            <a href="{{  $sortLink('category_name') }}"
                               class="text-decoration-none">Category {{  $sortIcon('category_name') }}
                            </a>
                        </th>
                        <th scope="col">
                            Category Image
                        </th>
                        <th scope="col">
                            Add Product
                        </th>
                        <th scope="col" class="text-center">
                            <a href="{{  $sortLink('subcategory_count') }}"
                               class="text-decoration-none">Total Subcategories {{  $sortIcon('subcategory_count') }}
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href="{{  $sortLink('product_count') }}"
                               class="text-decoration-none">Total products {{  $sortIcon('product_count') }}
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href="#"
                               class="text-decoration-none"> Show on Main
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href="#"
                               class="text-decoration-none"> Discount
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            @if(auth('admin')->user()->email==='gmta.constantine@gmail.com')
                                <th>
                                    {{$category->id}}
                                </th>
                            @endif
                            <td>{{$category->created_at->format('d/m/Y')}}</td>
                            <td>{{$category->name}}</td>
                            <td>
                                <img width="100" height="100"
                                     src="{{$category->getMedia('category_thumbnail')->first()?->getUrl()}}" alt="">
                            </td>
                            <td>
                                @if($category->subcategories->isEmpty())
                                    @include('backend.components.admin_categories.add_product_subcategories_modal')
                                @endif
                            </td>
                            <td class="text-center">
                                <a target="_blank"
                                   href="{{route('category.single',['locale'=>app()->getLocale(),'category'=>$category->slug])}}">
                                    {{$category->subcategories_count}}
                                </a>
                            </td>
                            <td class="text-center">
                                <a target="_blank"
                                   href="{{route('category.single',['locale'=>app()->getLocale(),'category'=>$category->slug])}}">
                                    {{$category->products_count}}
                                </a>
                            </td>
                            <td class="text-center">
                                @if($category->subcategories->isNotEmpty())
                                    ------
                                @else
                                    <form class="d-flex justify-content-center"
                                          action="{{route('category.change.main')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="category_id" value="{{$category->id}}">
                                        <div class="form-switch ios-switch switch-green switch-l">
                                            <input type="checkbox" class="ios-input" id="switch-4c{{$category->slug}}"
                                                   @checked($category->categoryOrder?->active==1)
                                                   onchange="this.form.submit()">
                                            <label class="custom-control-label"
                                                   for="switch-4c{{$category->slug}}"></label>
                                        </div>
                                    </form>
                                @endif
                            </td>
                            <td>
                                {{--  apply discount modal --}}
                                @if($category->subcategories->isEmpty())
                                    @include('backend.components.admin_categories.discount_modal_categories')
                                @endif
                            </td>
                            <td class="text-center">
                                {{--  edit category modal --}}
                                @include('backend.components.admin_categories.edit_category_modal_categories')
                            </td>
                        </tr>

                        @if($category->subcategories->isNotEmpty())
                            @foreach($category->subcategories as $subcategory)
                                <tr>
                                    @if(auth('admin')->user()->email==='gmta.constantine@gmail.com')
                                        <th>
                                            {{$subcategory->id}}
                                        </th>
                                    @endif
                                    <td>{{$subcategory->created_at->format('d/m/Y')}}</td>
                                    <td>{{$category->name}} --> {{$subcategory->name}}</td>
                                    <td>
                                        <img width="100" height="100"
                                             src="{{$subcategory->getMedia('category_thumbnail')->first()?->getUrl()}}"
                                             alt="">
                                    </td>
                                    <td>
                                        @include('backend.components.admin_categories.add_product_subcategories_modal')
                                    </td>
                                    <td class="text-center">
                                        ---
                                    </td>
                                    <td class="text-center">
                                        <a target="_blank"
                                           href="{{route('category.single',['locale'=>app()->getLocale(),'category'=>$subcategory->slug])}}">
                                            {{$subcategory->products_count}}
                                        </a>
                                    </td>
                                    <td>
                                        <form class="d-flex justify-content-center"
                                              action="{{route('category.change.main')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="subcategory_id" value="{{$subcategory->id}}">

                                            <div class="form-switch ios-switch switch-green switch-l">
                                                <input type="checkbox" class="ios-input"
                                                       id="switch-4c{{$subcategory->slug}}"
                                                       @checked($subcategory->categoryOrder?->active==1)
                                                       onchange="this.form.submit()">
                                                <label class="custom-control-label"
                                                       for="switch-4c{{$subcategory->slug}}"></label>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        @include('backend.components.admin_categories.discount_modal_subcategories')
                                    </td>
                                    <td class="text-center">
                                        {{--  edit subcategory modal --}}
                                        @include('backend.components.admin_categories.edit_subcategory_modal_categories')
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        @if($settings->use_sku==1)


        // generate rantom sku for products
        function generateSKU(length = 7) {
            const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            // let sku = prefix + "-";
            let sku = '';
            for (let i = 0; i < length; i++) {
                sku += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return sku;
        }

        @endif
    </script>
@endsection
