@extends('frontend.components.layout')

@section('front-category-single')
    {{--    @dd($category->subcategories->isEmpty())--}}
    {{--   create product modal if there are no subcategories in category--}}
    @if(auth('admin')->check() && $category->subcategories->isEmpty())
        <div class="d-flex justify-content-center gap-3 mb-3">
            <button
                data-bs-toggle="offcanvas"
                data-bs-target="#create-category-modal"
                class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-2">
                Add Product
            </button>
            <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
                 style="width:100%;max-width :400px" id="create-category-modal">
                <form class="content" action="{{route('product.store')}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="category_id" value="{{$category->id}}">
                    <input type="hidden" name="category_slug" value="{{$category->slug}}">
                    <p class="font-24 font-800 mb-3 text-center">Add Product</p>
                    <div class="d-flex gap-3 mb-3">
                        <label for="sku"
                               style="width: 100%"
                               class="color-theme text-center">SKU
                            <input type="text"
                                   name="sku"
                                   class="form-control rounded-xs"
                                   id="sku"
                                   value="{{old('sku')}}"
                                   placeholder="SKU"/>
                        </label>
                        @if($settings->use_stock==1)
                            <label for="stock"
                                   style="max-width: 80px"
                                   class="color-theme text-center">Stock
                                <input type="number"
                                       name="stock"
                                       class="form-control rounded-xs"
                                       id="stock"
                                       required
                                       value="{{old('stock')}}"
                                       placeholder="Stock"/>
                            </label>
                        @endif
                        <label for="price"
                               style="max-width: 80px"
                               class="color-theme text-center">Price
                            <input type="number"
                                   name="price"
                                   step="any"
                                   min="1"
                                   class="form-control rounded-xs"
                                   id="price"
                                   required
                                   value="{{old('price')}}"
                                   placeholder="Price"/>
                        </label>
                    </div>
                    @foreach($locales as $locale)
                        <div class="form-custom mb-3 form-floating">
                            <input type="text" name="product_name_{{$locale->abbr}}"
                                   class="form-control rounded-xs"
                                   id="c1{{$locale->abbr}}"
                                   @required($locale->main==1)
                                   value="{{old('product_name_'.$locale->abbr)}}"
                                   placeholder="Prodct Name"/>
                            <label for="c1{{$locale->abbr}}"
                                   class="color-theme">Name {{$locale->language}} </label>
                            @if($locale->main==1)
                                <span>(required)</span>
                            @endif
                        </div>
                        <div class="form-custom mb-3 form-floating">
                            <i class="bi bi-pencil-fill font-12 disabled"></i>
                            <textarea class="form-control rounded-xs"
                                      placeholder="Leave a comment here"
                                      name="description_{{$locale->abbr}}"
                                      @required($locale->main==1)
                                      id="c7{{$locale->abbr}}">{{old('description_'.$locale->abbr)}}</textarea>
                            <label for="c7{{$locale->abbr}}"
                                   class="color-theme">Description {{$locale->language}}</label>
                            @if($locale->main==1)
                                <span>(required)</span>
                            @endif
                        </div>
                    @endforeach
                    <div class="form-custom mb-3 form-floating">
                        <input type="text" name="video"
                               class="form-control rounded-xs"
                               id="video"
                               placeholder="Youtube Video Link"/>
                        <label for="video"
                               class="color-theme">Video Link</label>
                    </div>
                    <div class="">
                        <div id="preview" class="preview mb-2"></div>
                        <label for="fileInput" type="button"
                               class="btn btn-full btn-m text-uppercase font-700 rounded-s upload-file-text bg-highlight">
                            Upload Images
                            <input type="file" id="fileInput" class="upload-file" name="files[]" multiple
                                   accept="image/*">
                        </label>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
    {{--  categories grid--}}
    <div class="card card-style mx-0">
        <div class="content">
            <h2 class="text-center mb-3">
                {{$category->name}}
            </h2>
            {{--  only show filter and search when there are no subcategories  --}}
            @if($category->subcategories->isEmpty()) gggg
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
                               placeholder="Min Price" value="{{ request()->query('min_price') }}">
                        <input type="number" name="max_price" class="form-control rounded-xs" min="0" step="0.01"
                               placeholder="Max Price" value="{{ request()->query('max_price') }}">
                        <button style="all: unset;cursor:pointer" title="Apply">
                            <i class="bi bi-funnel-fill font-20"></i>
                        </button>
                        @if(request()->has('min_price') || request()->has('max_price'))
                            <a href="?sort={{ $currentSort }}" class="ms-2" title="Clear filters">
                                <i class="bi bi-x-circle font-20"></i>
                            </a>
                        @endif
                    </form>
                </div>
            @endif
            <div class="row mb-0 justify-content-center">
                @if($category->subcategories->isEmpty())
                    {{--  show products if no subcategories --}}
                    @foreach($category->products as $product)
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                            {{--  change for main and product order --}}
                            @if(auth('admin')->check())
                            <div class="d-flex justify-content-center gap-2 ">
                                <form action="{{route('product.main.update')}}" method="post"
                                      enctype="multipart/form-data" class="mb-1">
                                    @csrf
                                    <input type="hidden" value="{{$product->id}}" name="product_id">
                                    <div class="form-check form-check-custom  mb-2">
                                        <input class="form-check-input"
                                               name="for_main"
                                               type="checkbox"
                                               onchange="this.form.submit()"
                                               @checked($product->show_in_main==1)
                                               id="c2a2{{$product->slug}}">
                                        <label class="form-check-label" for="c2a2{{$product->slug}}">
                                            Main
                                        </label>
                                        <i class="is-checked color-green-dark bi bi-check-square"></i>
                                        <i class="is-unchecked color-red-dark bi bi-x-square"></i>
                                    </div>
                                </form>
                                <form action="{{route('product.order.update')}}" method="post"
                                      enctype="multipart/form-data" class="mb-1">
                                    @csrf
                                    <input type="hidden" value="{{$product->id}}" name="product_id">
                                    <div class="d-flex justify-content-center gap-3">
                                        <label class="form-check-label">
                                            Order
                                        </label>
                                        <select name="order" id=""
                                                onchange="this.form.submit()"
                                                style="width: 50px;"
                                                class="form-select rounded-xs px-1">
                                            @for ($i = 1; $i <= $productsCount; $i++)
                                                <option @selected($product->order==$i)
                                                        value="{{$i}}">
                                                    {{$i}}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </form>
                            </div>
                            @endif
                            <a href="{{route('product.single',['locale'=>app()->getLocale(),'product'=>$product->slug])}}">
                                <div class="card card-style custom-card m-0  bg-333"
                                     style="height: 200px;
                             @if($product->getMedia('product_image')->where('main',1)->first())
                              background-image: url({{asset($product->getMedia('product_image')->where('main',1)->first()->getUrl())}})
                                 @elseif($product->getMedia('product_image')->first())
                                 background-image: url({{asset($product->getMedia('product_image')->first()->getUrl())}})
                              @endif"
                                     data-card-height="200">
                                </div>
                                <h5 class="font-600 font-16 line-height-sm pt-3 text-center">
                                    {{$product->name}}
                                </h5>
                                <h2 class="mt-n1 text-center">
                                    {{$product->price}}
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 16"
                                         width="14" height="16"
                                         class="md:w-1-4 w-2-0 text-black-600 mb-1">
                                        <path fill="currentColor" fill-rule="evenodd"
                                              d="M14 8.094c-.017.013-.034.024-.05.039-.33.322-.662.644-.992.968-.015.014-.023.036-.034.055l-.028-.013c-.014-1.18-.352-2.26-1.044-3.233-.693-.974-1.614-1.66-2.751-2.096v.084l.001 4.045c0 .049-.014.082-.05.116L7.966 9.11l-.058.053V3.513c-.137-.015-.268-.038-.4-.043-.233-.01-.468-.017-.702-.011-.197.004-.394.03-.592.042-.047.004-.04.031-.04.06l-.002 1.246c0 1.045-.002 2.09-.001 3.136 0 .048-.014.082-.05.116L5.036 9.11l-.05.045V3.811l-.19.073c-.305.124-.601.265-.878.44-.362.229-.7.484-1.007.782-.312.303-.584.634-.82.995-.296.45-.515.934-.672 1.447-.106.345-.175.696-.206 1.053-.036.423-.042.847.016 1.272.065.48.185.944.37 1.392.17.409.379.798.649 1.153.154.202.319.398.49.587.277.308.596.57.94.805.358.243.738.449 1.14.616.385.16.789.258 1.2.336.354.067.71.082 1.07.082 1.91-.002 3.822 0 5.733 0h.094l-.054.055-1.106 1.08c-.007.006-.012.014-.018.021H.007c.013-.018.024-.039.04-.054.361-.353.724-.705 1.085-1.059.032-.032.065-.043.11-.043h1.861c-.201-.151-.402-.287-.584-.444-.249-.215-.494-.436-.72-.673-.254-.266-.477-.556-.679-.862-.201-.306-.379-.624-.528-.955-.308-.68-.498-1.39-.564-2.132-.039-.44-.038-.88.005-1.319.035-.356.107-.705.196-1.05.092-.361.216-.712.38-1.049.08-.163.152-.33.242-.487.105-.183.216-.365.34-.535.18-.247.363-.493.566-.721.275-.31.585-.587.916-.841.679-.522 1.425-.916 2.25-1.165.046-.014.062-.032.061-.08-.004-.41-.002-.82-.01-1.229-.002-.105.015-.188.111-.245.02-.012.035-.032.052-.048l.975-.953.06-.056v2.343c.58-.07 1.155-.076 1.734.002V2.27l-.001-1.05c0-.046.013-.078.047-.11.366-.352.73-.705 1.095-1.058l.054-.048V.08l.001 1.125v1.333c0 .04.012.056.054.07.198.066.398.13.59.208.612.25 1.176.578 1.695.98.302.234.58.494.839.77.285.304.536.635.756.987.265.424.494.865.652 1.337.092.278.166.562.244.844.029.103.046.21.068.315v.046z"></path>
                                    </svg>
                                </h2>
                            </a>
                        </div>
                    @endforeach
                @else
                    {{--  show  subcategories --}}fff
                    @foreach($subcategories as $subcategory)
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                            @if(auth('admin')->check())
                                <div class="d-flex justify-content-center gap-4 mb-1">
                                    <a href="#"
                                       data-bs-toggle="offcanvas"
                                       data-bs-target="#edit-category-modal_{{$subcategory->id}}"
                                       class="list-group-item">
                                        <i class="bi bi-pencil-square color-blue-dark font-18"></i>
                                    </a>
                                    {{--  edit subcategory modal --}}
                                    <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
                                         style="width:100%;max-width :400px"
                                         id="edit-category-modal_{{$subcategory->id}}">
                                        <form class="content" action="{{route('subcategory.update')}}" method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" value="{{$subcategory->id}}" name="subcategory_id">
                                            <p class="font-24 font-800 mb-3 text-center">Edit Category</p>
                                            @foreach($locales as $locale)
                                                <div class="form-custom mb-3 form-floating">
                                                    <input type="text" name="category_name_{{$locale->abbr}}"
                                                           class="form-control rounded-xs"
                                                           id="c1{{$locale->abbr}}"
                                                           @required($locale->main==1)
                                                           value="{{$subcategory->getTranslation('name',$locale->abbr)}}"
                                                           placeholder="Category Name"/>
                                                    <label for="c1{{$locale->abbr}}"
                                                           class="color-theme">Name {{$locale->language}} </label>
                                                    <span>(required)</span>
                                                </div>
                                            @endforeach
                                            <div class="d-flex justify-content-center gap-3 mb-3">
                                                <div class="form-check form-check-custom  mb-2">
                                                    <input class="form-check-input"
                                                           name="for_main"
                                                           type="checkbox"
                                                           @checked($subcategory->categoryOrder->active==1)
                                                           id="c2a2{{$subcategory->slug}}">
                                                    <label class="form-check-label" for="c2a2{{$subcategory->slug}}">
                                                        Show on Main Page
                                                    </label>
                                                    <i class="is-checked color-green-dark bi bi-check-square"></i>
                                                    <i class="is-unchecked color-red-dark bi bi-x-square"></i>
                                                </div>
                                                <div class="d-flex justify-content-center gap-3">
                                                    <label class="form-check-label">
                                                        Order
                                                    </label>
                                                    <select name="order" id=""
                                                            style="width: 70px;"
                                                            class="form-select rounded-xs px-1">
                                                        @for ($i = 1; $i <= $categoriesCount; $i++)
                                                            <option @selected($subcategory->order==$i)
                                                                    value="{{$i}}">
                                                                {{$i}}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="">
                                                <div id="previewEdit_{{$category->id}}" class="preview"></div>
                                                <label for="fileInputEdit_{{$subcategory->name}}" type="button"
                                                       class="btn btn-full btn-m text-uppercase font-700 rounded-s upload-file-text bg-highlight">
                                                    Upload New Image
                                                    <input type="file"
                                                           id="fileInputEdit_{{$subcategory->name}}"
                                                           class="upload-file"
                                                           name="files[]" multiple
                                                           accept="image/*">
                                                </label>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <button class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                                                    Update
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    {{--  delete subcategory modal --}}
                                    <a href="#" data-bs-toggle="offcanvas"
                                       data-bs-target="#delete-category-modal_{{$subcategory->id}}"
                                       class="list-group-item">
                                        <i class="bi bi-trash color-red-dark font-18"></i>
                                    </a>
                                    <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
                                         style="width:100%;max-width :400px"
                                         id="delete-category-modal_{{$subcategory->id}}">
                                        <form class="content" action="{{route('subcategory.delete')}}" method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" value="{{$subcategory->id}}" name="category_id">
                                            <p class="font-24 font-800 mb-3 text-center">Delet
                                                Category {{$subcategory->name}} ?</p>

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
                                </div>
                            @endif
                            <a href="{{route('category.single',$subcategory->slug)}}">
                                <div class="card card-style custom-card m-0 bg-21"
                                     data-card-height="140"
                                     style="height: 140px; background-image: url({{$subcategory->getMedia('category_thumbnail')->first()?->getUrl()}})">
                                </div>
                                <h5 class="font-600 font-16 line-height-sm pt-3 text-center">
                                    {{$subcategory->name}}
                                </h5>
                            </a>
                        </div>
                    @endforeach
                @endif
                @if($category->products->isEmpty() && !$category->subcategories->empty() )
                    @include('frontend.placeholders.category_products')
                @endif
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

        const randomSKU = generateSKU(6);
        document.getElementById('sku').value = randomSKU;

        @endif
    </script>

@endsection
