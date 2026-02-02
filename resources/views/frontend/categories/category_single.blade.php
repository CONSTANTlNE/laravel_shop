@extends('frontend.components.layout')

@section('index-categorყ-single')
    <title>{{$category->name}} | shopz.ge</title>
    <link rel="canonical" href="{{url()->current()}}">
    <meta name="description" content="ონლაინ მაღაზია, დაბალი ფასები და სწრაფი მიწოდება">
    <meta name="keywords" content="ონლაინ მაღაზია">
    <meta property="og:title" content="shopz.ge | {{$category->name}}">
    <meta property="og:description" content="ონლაინ მაღაზია, დაბალი ფასები და სწრაფი მიწოდება">
    <meta property="og:image" content="{{asset('shopz_man2.jpeg')}}">
    <meta property="og:url" content="{{url()->current()}}">
@endsection

@push('json-ld')
    <script type="application/ld+json">
        {
          "@@context": "https://schema.org",
  "@type": "CollectionPage",
  "name": "{{ $category->name }}",
  "description": "{{ Str::limit(strip_tags($category->name), 160) }}",
  "url": "{{ url()->current() }}",
  "mainEntity": {
    "@type": "ItemList",
    "numberOfItems": {{ $category->products->count() }},
    "itemListElement": [
        @foreach($category->products as $index => $product)
            {
              "@type": "ListItem",
              "position": {{ $index + 1 }},
        "item": {
          "@type": "Product",
          "name": "{{ $product->name }}",
          "url": "{{ route('product.single', $product->slug) }}",
          "image": "{{ $product->getFirstMediaUrl('product_image') ?: asset('defaults/default_placeholder.png') }}",
          "description": "{{ Str::limit(strip_tags($product->description), 160) }}",
          "offers": {
            "@type": "Offer",
            "price": "{{ $product->price }}",
            "priceCurrency": "GEL",
            "availability": "https://schema.org/InStock"
          }
        }
      }{{ !$loop->last ? ',' : '' }}
        @endforeach
        ]
      }
    }
    </script>
@endpush

@section('front-category-single')
    {{--    @dd($category->subcategories->isEmpty())--}}
    {{--   create product modal if there are no subcategories in category--}}
    @if(auth('admin')->check() && $category->subcategories->isEmpty())
        <div class="d-flex justify-content-center gap-3 mb-3">
            <button
                data-bs-toggle="offcanvas"
                data-bs-target="#create-category-modal"
                class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-2">
                {{__('Add Product')}}
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
            @if($category->subcategories->isEmpty())
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
                        @php
                            $mainImage = $product->media->firstWhere('custom_properties.main', 1);
                            $just_image=$product->media->first();
                        @endphp
                        <div  class="col-6 col-sm-6 col-md-4 col-lg-3 text-center mb-3 d-flex flex-column justify-content-between " >
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
                            @include('frontend.components.single_product_component')
                        </div>
                    @endforeach
                @else

                    {{--  show  subcategories --}}
                    @foreach($subcategories as $subcategory)
{{--                        @dd($subcategory->getMedia('category_image')->first() ,$subcategory->getMedia('category_image')->first()?->getUrl('thumbnail') )--}}
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
                                                           @checked($subcategory->categoryOrder?->active==1)
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
                                     style="height: 140px; background-image: url({{$subcategory->getMedia('category_image')->first()?->getUrl('thumbnail')}})">
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
        @if($settings->use_sku==1 && $category->subcategories->isEmpty())
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
