@extends('frontend.components.layout')

@section('admin-discounts')

    <div class="card overflow-visible card-style m-0 mb-3">
        <div class="content mb-0">
            <div class="d-flex justify-content-start gap-2 align-items-center">
                <h4>{{__('Discounts')}} </h4>
                <button
                    class="btn btn-full btn-s font-900  rounded-sm shadow-l bg-blue-dark mb-1 pt-2 pb-2"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#edit_name">
                    {{__('Add Discount')}}
                </button>
                {{--  create discount --}}
                <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
                     style="width:100%;max-width :400px" id="edit_name">
                    <form class="content" action="{{route('discount.store')}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <p class="font-24 font-800 mb-3 text-center">{{__('Create Discount')}}</p>
                        <div class="d-flex justify-content-between gap-3 ">
                            <div class="form-custom mb-3 form-floating">
                                <input type="text" name="percent"
                                       class="form-control rounded-xs"
                                       id="c1"
                                       style="width: 100px"
                                       value=""
                                       placeholder="%"/>
                                <label for="c1"
                                       class="color-theme">{{__('Percent')}}</label>
                            </div>
                            <div class="form-custom mb-3 form-floating w-100">
                                <input type="date" name="valid_till"
                                       class="form-control rounded-xs"
                                       id="c1"/>
                                <label for="c"
                                       class="color-theme">{{__('Valid Till')}}</label>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center gap-2">
                            <div class="form-check form-check-custom">
                                <input class="form-check-input" name="increase_price" checked type="checkbox" value=""
                                       id="increase_price">
                                <label class="form-check-label" for="increase_price">

                                </label>
                                <i class="is-checked color-green-dark bi bi-check-square"></i>
                                <i class="is-unchecked color-red-dark bi bi-x-square"></i>
                            </div>
                        </div>
                        <div class="form-custom mb-3 form-floating">
                            <input type="text" name="product_name_"
                                   class="form-control rounded-xs"
                                   id="c1"
                                   value=""
                                   placeholder="Prodct Name"/>
                            <label for="c"
                                   class="color-theme">{{__('Comment')}}</label>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button
                                onclick="showOverlay()"
                                class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                                {{__('Create')}}
                            </button>
                        </div>
                    </form>
                </div>

            </div>
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
                    <input type="hidden" name="sort_by"
                           value="{{ request()->query('sort_by', $sortBy ?? 'created_at') }}"/>
                    <input type="hidden" name="sort_dir"
                           value="{{ request()->query('sort_dir', $sortDir ?? 'desc') }}"/>
                </div>
                <div class="d-flex gap-2 justify-content-center align-items-center">
                    {{--                    <button class="btn btn-sm btn-primary rounded-xs">Apply</button>--}}
                    <a class="btn btn-sm btn-secondary rounded-xs"
                       href="{{ route('discount.all', ['locale'=>app()->getLocale()]) }}">
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
                        <th scope="col" class="text-center">
                            <a href="{{  $sortLink('created_at') }}"
                               class="text-decoration-none">
                                Created {{  $sortIcon('created_at') }}
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            Discount
                        </th>
                        <th scope="col" class="text-center">
                            <a href="{{  $sortLink('valid_till') }}"
                               class="text-decoration-none">Valid Till {{  $sortIcon('valid_till') }}
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href="{{  $sortLink('product_count') }}"
                               class="text-decoration-none">Increase Price {{  $sortIcon('product_count') }}
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href="#"
                               class="text-decoration-none"> Active
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href="#"
                               class="text-decoration-none"> Products
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href="#"
                               class="text-decoration-none"> Comment
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href="#"
                               class="text-decoration-none"> Action
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($discounts as $index => $discount)
                        <tr>
                            <td class="text-center">{{$discount->created_at->format('d/m/Y')}}</td>
                            <td class="text-center">{{$discount->discount_percentage}}</td>
                            <td class="text-center">{{$discount->valid_till->format('d/m/Y')}}</td>
                            <td class="text-center">

                                    @if($discount->increase_price==true)
                                        <span class="bg-green-dark p-2 py-1 rounded-1 font-13 font-600">
                                           YES
                                         </span>
                                    @else
                                        <span class="bg-red-dark p-2 py-1 rounded-1 font-13 font-600">
                                            NO
                                        </span>
                                    @endif
                            </td>
                            <td class="text-center">
                                @if($discount->active==true)
                                    <span class="bg-green-dark p-2 py-1 rounded-1 font-13 font-600">
                                           YES
                                    </span>
                                @else
                                    <span class="bg-red-dark p-2 py-1 rounded-1 font-13 font-600">
                                            NO
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">products</td>
                            <td class="text-center">{{$discount->comment}}</td>
                            <td class="d-flex justify-content-center">
                                {{--  edit discount modal --}}
                                <button style="all:unset;cursor:pointer"
                                        class="mb-1" data-bs-toggle="offcanvas"
                                        data-bs-target="#edit_discount{{$index}}">
                                    <i class="bi bi-pencil-square color-blue-dark font-30"></i>
                                </button>
                                <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
                                     style="width:100%;max-width :400px" id="edit_discount{{$index}}">
                                    <form class="content" action="{{route('discount.store')}}" method="post"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <p class="font-24 font-800 mb-3 text-center">Edit Discount</p>
                                        <div class="d-flex justify-content-between gap-3 ">
                                            <div class="form-custom mb-3 form-floating">
                                                <input type="text" name="percent"
                                                       class="form-control rounded-xs"
                                                       id="c1"
                                                       style="width: 100px"
                                                       value=""
                                                       placeholder="%"/>
                                                <label for="c1"
                                                       class="color-theme">Percent </label>
                                            </div>
                                            <div class="form-custom mb-3 form-floating w-100">
                                                <input type="date" name="valid_till"
                                                       class="form-control rounded-xs"
                                                       value="{{$discount->valid_till}}"
                                                       id="c1"/>
                                                <label for="c"
                                                       class="color-theme">Valid Till </label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center gap-2">
                                            <div class="form-check form-check-custom">
                                                <input class="form-check-input" name="increase_price" checked
                                                       type="checkbox" value="" id="increase_price">
                                                <label class="form-check-label" for="increase_price">
                                                    Increase Price after deadline
                                                </label>
                                                <i class="is-checked color-green-dark bi bi-check-square"></i>
                                                <i class="is-unchecked color-red-dark bi bi-x-square"></i>
                                            </div>
                                        </div>
                                        <div class="form-custom mb-3 form-floating">
                                            <input type="text" name="product_name_"
                                                   class="form-control rounded-xs"
                                                   id="c1"
                                                   value=""
                                                   placeholder="Prodct Name"/>
                                            <label for="c"
                                                   class="color-theme">Comment </label>
                                        </div>

                                        <div class="d-flex justify-content-center">
                                            <button
                                                onclick="showOverlay()"
                                                class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                                                {{__('Update')}}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                {{--  delete discount modal --}}
                                <a href="#" data-bs-toggle="offcanvas" data-bs-target="#delete_discount{{$index}}"
                                   class="list-group-item">
                                    <i class="bi bi-trash color-red-dark font-30"></i>
                                </a>
                                <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
                                     style="width:100%;max-width :400px" id="delete_discount{{$index}}">
                                    <form class="content" action="{{route('discount.delete')}}"
                                          method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="_token"
                                               value="sJR6uDv3cLjanje6hsEveQh50MEqW9uFgmBcnbRs" autocomplete="off">
                                        <input type="hidden" value="2" name="category_id">
                                        <p class="font-24 font-800 mb-3 text-center">
                                            Delete Discount კომპიუტერის აქსესუარები ?
                                        </p>
                                        <div class="d-flex justify-content-center gap-4">
                                            <button type="button" data-bs-dismiss="offcanvas"
                                                    class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                                                Cancel
                                            </button>
                                            <button class="btn btn-full gradient-red shadow-bg shadow-bg-s mt-4">
                                                Delete
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{--                @if(method_exists($categories, 'links'))--}}
                {{--                    <div class="d-flex justify-content-center align-items-center gap-4 mt-3">--}}
                {{--                        {{ $categories->appends(request()->query())->links() }}--}}
                {{--                    </div>--}}
                {{--                @endif--}}
            </div>
        </div>
    </div>

@endsection
