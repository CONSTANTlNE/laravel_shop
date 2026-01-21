@extends('frontend.components.layout')

@section('admin-coupons')

    <div class="card overflow-visible card-style m-0 mb-3">
        <div class="content mb-0">
            <h4 class="text-center">Coupons </h4>
            <div class="d-flex justify-content-center gap-2 mt-3 mb-2">
                {{--  cruate promoter modal --}}
                <button
                    class="btn btn-full btn-s font-900  rounded-sm shadow-l bg-blue-dark mb-1 pt-2 pb-2"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#create_promoter">
                    Promoters
                </button>
                <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
                     style="width:100%;max-width :400px" id="create_promoter">
                    <form class="content" action="{{route('promoter.store')}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <p class="font-24 font-800 mb-3 text-center">Create Promoter</p>
                        <div class="form-custom mb-3 form-floating">
                            <input type="text" name="name"
                                   class="form-control rounded-xs"
                                   id="promoter_name"
                                   value=""
                                   required
                                   placeholder="Promoter Name"/>
                            <label for="promoter_name"
                                   class="color-theme">Name </label>
                        </div>
                        <div class="form-custom mb-3 form-floating">
                            <input type="text" name="mobile"
                                   class="form-control rounded-xs"
                                   id="promoter_mobile"
                                   value=""
                                   placeholder="Promoter Name"/>
                            <label for="promoter_mobile"
                                   class="color-theme">Mobile </label>
                        </div>
                        <div class="form-custom mb-3 form-floating">
                            <input type="text" name="email"
                                   class="form-control rounded-xs"
                                   id="promoter_email"
                                   value=""
                                   placeholder="Promoter Email"/>
                            <label for="promoter_email"
                                   class="color-theme">Email </label>
                        </div>
                        <div class="form-custom mb-3 form-floating">
                            <input type="text" name="comment"
                                   class="form-control rounded-xs"
                                   id="promoter_comment"
                                   value=""
                                   placeholder="Prodct Name"/>
                            <label for="promoter_comment"
                                   class="color-theme">Comment </label>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button
                                class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                                Create
                            </button>
                        </div>
                    </form>
                    @if($promoters->isNotEmpty())
                        <p class="font-24 font-800 mt-3 mb-0 text-center">Promoters</p>
                        <div class="table-responsive p-1">
                            <table class="table color-theme mb-2">
                                <thead>
                                <tr>
                                    <th scope="col" class="text-center">Name</th>
                                    <th scope="col" class="text-center">Mobile</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($promoters as $promoter)
                                    <tr>
                                        <td class="text-center">{{$promoter->name}}</td>
                                        <td class="text-center">{{$promoter->mobile}}</td>
                                        <td class="d-flex justify-content-around">
                                            <button style="all:unset;cursor:pointer" class="mb-1"
                                                    data-bs-toggle="offcanvas"
                                                    onclick='passData(@json($promoter))'
                                                    data-bs-target="#edit_promoter">
                                                <i class="bi bi-pencil-square color-blue-dark font-18"></i>
                                            </button>

                                            <form action="{{route('promoter.delete')}}" method="post">
                                                @csrf
                                                <input type="hidden" value="{{$promoter->id}}" name="promoter_id">
                                                <button style="all:unset;cursor:pointer" class="mb-1">
                                                    <i class="bi bi-trash color-red-dark font-18"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                {{--  create coupon modal --}}
                <button
                    class="btn btn-full btn-s font-900  rounded-sm shadow-l bg-blue-dark mb-1 pt-2 pb-2"
                    data-bs-toggle="offcanvas"
                    onclick="document.getElementById('promo_code').value=generateCode()"
                    data-bs-target="#create_copon">
                    Create Coupon
                </button>
                <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
                     style="width:100%;max-width :400px" id="create_copon">
                    <form class="content" action="{{route('coupon.store')}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <p class="font-24 font-800 mb-3 text-center">Create Coupon</p>
                        <div class="d-flex justify-content-center">
                            <select required name="promoter_id" class="form-select rounded-xs w-auto d-inline">
                                <option value="">
                                    Select Promoter
                                </option>
                                @foreach($promoters as $promoter2)
                                    <option value="{{$promoter2->id}}">
                                        {{$promoter2->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex justify-content-between gap-3 ">
                            <div class="form-custom mb-3 form-floating">
                                <input type="text" name="percent"
                                       class="form-control rounded-xs"
                                       id="coupon_percent"
                                       style="width: 100px"
                                       value=""
                                       required
                                       placeholder="%"/>
                                <label for="coupon_percent"
                                       class="color-theme">
                                    Percent
                                </label>
                            </div>
                            <div class="form-custom mb-3 form-floating w-100">
                                <input type="date" name="valid_till"
                                       class="form-control rounded-xs"
                                       required
                                       id="valid_till"/>
                                <label for="valid_till"
                                       class="color-theme">Valid Till </label>
                            </div>
                        </div>
                        <div class="form-custom mb-3 form-floating">
                            <input type="text" name="promo_code"
                                   class="form-control rounded-xs"
                                   id="promo_code"
                                   value=""
                                   required
                                   placeholder="Promo Code"/>
                            <label for="promo_code"
                                   class="color-theme">
                                Promo Code
                            </label>
                        </div>
                        <div class="form-custom mb-3 form-floating">
                            <input type="text" name="comment"
                                   class="form-control rounded-xs"
                                   id="comment_coupon"
                                   value=""
                                   placeholder="Prodct Name"/>
                            <label for="comment_coupon"
                                   class="color-theme">
                                Comment
                            </label>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button
                                {{--                                onclick="showOverlay()"--}}
                                class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                                Create
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
                        <th scope="col" class="text-center">
                            <a href="{{  $sortLink('created_at') }}"
                               class="text-decoration-none">
                                Created {{  $sortIcon('created_at') }}
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            Code
                        </th>
                        <th scope="col" class="text-center">
                            Discount
                        </th>
                        <th scope="col" class="text-center">
                            <a href="{{  $sortLink('valid_till') }}"
                               class="text-decoration-none">Valiity {{  $sortIcon('valid_till') }}
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
                    @foreach($coupons as $index => $discount)
                        <tr>
                            <td class="text-center">{{$discount->created_at->format('d/m/Y')}}</td>
                            <td class="text-center">
                                {{$discount->code}}
                            </td>
                            <td class="text-center">{{$discount->discount_percentage}}</td>
                            <td class="text-center">{{$discount->valid_till}}</td>
                            <td class="text-center">
                                <form class="d-flex justify-content-center" action="{{route('coupon.activate')}}"
                                      method="post">
                                    @csrf
                                    <input type="hidden" name="coupon_id" value="{{$discount->id}}">
                                    <div class="form-switch ios-switch switch-green switch-l">
                                        <input type="checkbox"
                                               class="ios-input"
                                               id="switch-4c-{{$discount->id}}"
                                               @checked($discount->active==1)
                                               onchange="this.form.submit()">
                                        <label class="custom-control-label" for="switch-4c-{{$discount->id}}"></label>
                                    </div>
                                </form>
                            </td>
                            <td class="text-center">products</td>
                            <td class="text-center">{{$discount->comment}}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    {{--  delete coupon modal --}}
                                    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#delete_discount{{$index}}"
                                       class="list-group-item">
                                        <i class="bi bi-trash color-red-dark font-18"></i>
                                    </a>
                                </div>
                                <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
                                     style="width:100%;max-width :400px" id="delete_discount{{$index}}">
                                    <form class="content" action="{{route('coupon.delete')}}"
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

    {{--edit promoter modal--}}
    <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
         style="width:100%;max-width :400px" id="edit_promoter">
        <form class="content" action="{{route('promoter.update')}}" method="post"
              enctype="multipart/form-data">
            <input type="hidden">
            @csrf
            <p class="font-24 font-800 mb-3 text-center">Update Promoter</p>
            <div class="form-custom mb-3 form-floating">
                <input type="text" name="name"
                       class="form-control rounded-xs"
                       id="promoter_name_edit"
                       value=""
                       required
                       placeholder="Promoter Name"/>
                <label for="promoter_name_edit"
                       class="color-theme">Name </label>
            </div>
            <div class="form-custom mb-3 form-floating">
                <input type="text" name="mobile"
                       class="form-control rounded-xs"
                       id="promoter_mobile_edit"
                       value=""
                       placeholder="Promoter Name"/>
                <label for="promoter_mobile_edit"
                       class="color-theme">Mobile </label>
            </div>
            <div class="form-custom mb-3 form-floating">
                <input type="text" name="email"
                       class="form-control rounded-xs"
                       id="promoter_email_edit"
                       value=""
                       placeholder="Promoter Email"/>
                <label for="promoter_email_edit"
                       class="color-theme">Email </label>
            </div>
            <div class="form-custom mb-3 form-floating">
                <input type="text" name="comment"
                       class="form-control rounded-xs"
                       id="promoter_comment_edit"
                       value=""
                       placeholder="Prodct Name"/>
                <label for="promoter_comment_edit"
                       class="color-theme">Comment </label>
            </div>

            <div class="d-flex justify-content-center">
                <button
                    class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                    Update
                </button>
            </div>
        </form>
    </div>

    <script>

        function generateCode(length = 6) {
            const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            // let sku = prefix + "-";
            let sku = '';
            for (let i = 0; i < length; i++) {
                sku += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return sku;
        }


        function passData(data) {
            document.getElementById('promoter_name_edit').value = data.name
            document.getElementById('promoter_mobile_edit').value = data.mobile
            document.getElementById('promoter_email_edit').value = data.email
            document.getElementById('promoter_comment_edit').value = data.comment
        }
    </script>
@endsection
