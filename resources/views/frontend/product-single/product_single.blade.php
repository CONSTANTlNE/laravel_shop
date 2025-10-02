@extends('frontend.components.layout')

@section('product-single')

{{--    @dd($product->getMedia('product_image')->first()->getUrl())--}}
    <div style="margin-left: 0;margin-right: 0;
         @if($main_image)
            background-image: url({{$main_image->getUrl()}})
        @elseif($product->getMedia('product_image')->first())
            background-image: url({{asset($product->getMedia('product_image')->first()->getUrl())}})
        @endif"
         class="card card-style preload-img product_card_height">
        <div class="card-overlay bg-gradient"></div>
    </div>


    <div style="margin-left: 0;margin-right: 0" class="card card-style">
        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="flex">
                    <div class="d-flex justify-content-start align-items-center gap-2 mb-1">
                        <h1 class="font-30">{{$product->name}}</h1>
                        @if(auth('admin')->check())
                            <button
                                class=" btn btn-full btn-s font-900  rounded-s shadow-l bg-blue-dark p-0 px-1"
                                data-bs-toggle="offcanvas"
                                data-bs-target="#edit_name">
                                <i class="bi bi-pencil-square color-black-dark font-18"></i>
                            </button>
                            {{--  edit name modal--}}
                            <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
                                 style="width:100%;max-width :400px" id="edit_name">
                                <form class="content" action="{{route('product.name.update')}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                    <p class="font-24 font-800 mb-3 text-center">Edit Product Name</p>
                                    @foreach($locales as $locale)
                                        <div class="form-custom mb-3 form-floating">
                                            <input type="text" name="product_name_{{$locale->abbr}}"
                                                   class="form-control rounded-xs"
                                                   id="c1{{$locale->abbr}}"
                                                   @required($locale->main==1)
                                                   value="{{$product->getTranslation('name',$locale->abbr)}}"
                                                   placeholder="Prodct Name"/>
                                            <label for="c1{{$locale->abbr}}"
                                                   class="color-theme">Name {{$locale->language}} </label>
                                            @if($locale->main==1)
                                                <span>(required)</span>
                                            @endif
                                        </div>
                                    @endforeach
                                    <div class="d-flex justify-content-center">
                                        <button
                                            onclick="showOverlay()"
                                            class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                                            Update
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="flex">
                    <h3 class="font-20">
                        <del class="opacity-20 font-300">$30<sup>.00</sup></del>
                        25
                        <svg xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 14 16"
                             width="14" height="16"
                             class="md:w-1-4 w-2-0 text-black-600 mb-1">
                            <path
                                fill="currentColor" fill-rule="evenodd"
                                d="M14 8.094c-.017.013-.034.024-.05.039-.33.322-.662.644-.992.968-.015.014-.023.036-.034.055l-.028-.013c-.014-1.18-.352-2.26-1.044-3.233-.693-.974-1.614-1.66-2.751-2.096v.084l.001 4.045c0 .049-.014.082-.05.116L7.966 9.11l-.058.053V3.513c-.137-.015-.268-.038-.4-.043-.233-.01-.468-.017-.702-.011-.197.004-.394.03-.592.042-.047.004-.04.031-.04.06l-.002 1.246c0 1.045-.002 2.09-.001 3.136 0 .048-.014.082-.05.116L5.036 9.11l-.05.045V3.811l-.19.073c-.305.124-.601.265-.878.44-.362.229-.7.484-1.007.782-.312.303-.584.634-.82.995-.296.45-.515.934-.672 1.447-.106.345-.175.696-.206 1.053-.036.423-.042.847.016 1.272.065.48.185.944.37 1.392.17.409.379.798.649 1.153.154.202.319.398.49.587.277.308.596.57.94.805.358.243.738.449 1.14.616.385.16.789.258 1.2.336.354.067.71.082 1.07.082 1.91-.002 3.822 0 5.733 0h.094l-.054.055-1.106 1.08c-.007.006-.012.014-.018.021H.007c.013-.018.024-.039.04-.054.361-.353.724-.705 1.085-1.059.032-.032.065-.043.11-.043h1.861c-.201-.151-.402-.287-.584-.444-.249-.215-.494-.436-.72-.673-.254-.266-.477-.556-.679-.862-.201-.306-.379-.624-.528-.955-.308-.68-.498-1.39-.564-2.132-.039-.44-.038-.88.005-1.319.035-.356.107-.705.196-1.05.092-.361.216-.712.38-1.049.08-.163.152-.33.242-.487.105-.183.216-.365.34-.535.18-.247.363-.493.566-.721.275-.31.585-.587.916-.841.679-.522 1.425-.916 2.25-1.165.046-.014.062-.032.061-.08-.004-.41-.002-.82-.01-1.229-.002-.105.015-.188.111-.245.02-.012.035-.032.052-.048l.975-.953.06-.056v2.343c.58-.07 1.155-.076 1.734.002V2.27l-.001-1.05c0-.046.013-.078.047-.11.366-.352.73-.705 1.095-1.058l.054-.048V.08l.001 1.125v1.333c0 .04.012.056.054.07.198.066.398.13.59.208.612.25 1.176.578 1.695.98.302.234.58.494.839.77.285.304.536.635.756.987.265.424.494.865.652 1.337.092.278.166.562.244.844.029.103.046.21.068.315v.046z"></path>
                        </svg>
                    </h3>
                    @if(auth('admin')->check())
                        <div class="d-flex justify-content-start">
                            <button
                                class=" btn btn-full btn-s font-900  rounded-s shadow-l bg-blue-dark p-0 px-1"
                                data-bs-toggle="offcanvas"
                                data-bs-target="#edit_price">
                                <i class="bi bi-pencil-square color-black-dark font-18"></i>
                            </button>
                            {{--  edit price modal--}}
                            <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
                                 style="width:100%;max-width :400px" id="edit_price">
                                <form class="content" action="{{route('product.price.update')}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                    <div class="d-flex justify-content-center align-items-center ">
                                        <i class="bi bi-pencil-fill font-12 disabled"></i>
                                        <label for="price" style="max-width: 80px" class="color-theme text-center">Edit
                                            Price
                                            <input type="number" name="price" class="form-control rounded-xs"
                                                   id="price" required=""
                                                   value="{{$product->price}}"
                                                   placeholder="Price">
                                        </label>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button
                                            onclick="showOverlay()"
                                            class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                                            Update
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                    <span
                        class="bg-green-dark float-end rounded-xs text-uppercase font-900 font-9 pe-2 ps-2 pb-0 pt-0 line-height-s mt-n1">
                        In stock
                    </span>
                </div>
            </div>


            @if(auth('admin')->check())
                <div class="d-flex justify-content-start">
                    <button style="all:unset;cursor:pointer"
                            class="mb-1"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#edit_description">
                        <i class="bi bi-pencil-square color-blue-dark font-18"></i>
                    </button>
                    {{--  edit description modal --}}
                    <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
                         style="width:100%;max-width :400px" id="edit_description">
                        <form class="content" action="{{route('product.description.update')}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                            <p class="font-24 font-800 mb-3 text-center">Edit Description</p>
                            @foreach($locales as $locale)
                                <div class="form-custom mb-3 form-floating">
                                    <i class="bi bi-pencil-fill font-12 disabled"></i>
                                    <textarea class="form-control rounded-xs "
                                              placeholder="Product Description"
                                              name="description_{{$locale->abbr}}"
                                              @required($locale->main==1) id="c7ka">{{$product->getTranslation('description',$locale->abbr)}}</textarea>
                                    <label for="c7ka"
                                           class="color-theme">Product Description {{$locale->language}}</label>
                                    @if($locale->main==1)
                                        <span>(required)</span>
                                    @endif
                                </div>
                            @endforeach

                            <div class="d-flex justify-content-center">
                                <button
                                    onclick="showOverlay()"
                                    class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
            <p>
                @if($product->description)
                    {{$product->description}}
                @else
                    The best selling Mobile Progressive Web App on the Envato Marketplaces just got even better now,
                    with
                    4.0 introducing
                    Bootstrap 5.x compatibility and a tone of new gorgeous features!
                @endif
            </p>


            <div id="features_form" class="row mb-0">
                @if($product->features->isNotEmpty())
                    @foreach($product->features as $feature_index => $feature)
                        <div class="col-4">
                            <div class="d-flex gap-1">
                                <span class="font-11">{{$feature->feature_name}}</span>
                                @if(auth('admin')->check())
                                    <button style="all:unset;cursor:pointer"
                                            class="mb-1"
                                            data-bs-toggle="offcanvas"
                                            data-bs-target="#edit_feature{{$feature_index}}">
                                        <i class="bi bi-pencil-square color-blue-dark font-18"></i>
                                    </button>
                                    {{--  edit feature modal--}}
                                    <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
                                         style="width:100%;max-width :400px" id="edit_feature{{$feature_index}}">
                                        <form class="content" action="{{route('product.feature.update')}}" method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="feature_id" value="{{$feature->id}}">
                                            <p class="font-24 font-800 mb-3 text-center">Edit Feature</p>
                                            @foreach($locales as $locale)
                                                <div class="form-custom mb-3 form-floating">
                                                    <input type="text"
                                                           name="feature_name_{{$locale->abbr}}"
                                                           class="form-control rounded-xs"
                                                           id="c1{{$locale->abbr}}"
                                                           value="{{$feature->getTranslation('feature_name',$locale->abbr)}}"
                                                           placeholder="Feature Name"/>
                                                    <label for="c1{{$locale->abbr}}"
                                                           class="color-theme">Feature Name {{$locale->language}}
                                                    </label>
                                                </div>
                                                <div class="form-custom mb-3 form-floating">
                                                    <input type="text"
                                                           name="feature_text_{{$locale->abbr}}"
                                                           class="form-control rounded-xs"
                                                           id="c2{{$locale->abbr}}"
                                                           value="{{$feature->getTranslation('feature_text',$locale->abbr)}}"
                                                           placeholder="Text"/>
                                                    <label for="c1{{$locale->abbr}}"
                                                           class="color-theme">Feature Text {{$locale->language}}
                                                    </label>
                                                </div>
                                            @endforeach

                                            <div class="d-flex justify-content-center">
                                                <button
                                                    onclick="showOverlay()"
                                                    class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                                                    Update
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    <form action="{{route('product.feature.delete')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="feature_id" value="{{$feature->id}}">
                                        <button style="all:unset;cursor:pointer"
                                                class="mb-1"
                                                data-bs-toggle="offcanvas"
                                                data-bs-target="#delete_feature{{$feature_index}}">
                                            <i class="bi bi-trash color-red-dark font-18"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <p class="mt-n2 mb-3">
                                <strong class="color-theme">{{$feature->feature_text}}</strong>
                            </p>
                        </div>
                    @endforeach
                @else
                    @if(auth('admin')->check())
                        <div class="text-center"> Features example ( Only shown for admin users )</div>
                        @include('frontend.placeholders.product_features')
                    @endif
                @endif
                @if(auth('admin')->check())
                    {{--  add product features --}}
                    <div class="d-flex justify-content-center align-items-center">
                        <form class="col-12" style="max-width: 500px;" method="post"
                              action="{{route('product.feature.store')}}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                            <p class="text-center">Add Product Features</p>
                            @foreach($locales as $locale)
                                <div class="form-custom mb-3 form-floating">
                                    <input type="text"
                                           name="feature_name_{{$locale->abbr}}"
                                           class="form-control rounded-xs"
                                           id="c1{{$locale->abbr}}"
                                           value="{{old('feature_name_'.$locale->abbr)}}"
                                           placeholder="Prodct Name"/>
                                    <label for="c1{{$locale->abbr}}"
                                           class="color-theme">Feature Name {{$locale->language}}
                                    </label>
                                </div>
                                <div class="form-custom mb-3 form-floating">
                                    <input type="text"
                                           name="feature_text_{{$locale->abbr}}"
                                           class="form-control rounded-xs"
                                           id="c2{{$locale->abbr}}"
                                           value="{{old('feature_text_'.$locale->abbr)}}"
                                           placeholder="Prodct Name"/>
                                    <label for="c1{{$locale->abbr}}"
                                           class="color-theme">Feature Text {{$locale->language}}
                                    </label>
                                </div>
                            @endforeach
                            <div class="d-flex justify-content-center align-items-center">
                                <button href="#"
                                        onclick="showOverlay()"
                                        class="btn btn-full btn-s font-900  rounded-sm shadow-l bg-blue-dark mb-1 pt-2 pb-2">
                                    Add Feature
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>

            <div class="divider mt-3"></div>

            <div class="d-flex">
                <div class="flex-grow-1">
                    <span class="font-11">Share with the World </span>
                    <p class="mt-n2">
                        <strong class="color-theme">Share or Save for Later</strong>
                    </p>
                </div>
                <div class="flex-shrink-1 mt-1">
                    <a href="#" data-menu="menu-share" class="icon icon-xs rounded-xl shadow-m ms-2 bg-blue-dark">
                        <i class="bi bi-share-fill font-15"></i>
                    </a>
                </div>
            </div>

            <div class="d-flex justify-content-center pt-4">
                <div class="d-flex gap-2">
                    <div class="align-self-center">
                        <div class="stepper rounded-s">
                            <a href="#" class="stepper-sub float-start"><i
                                    class="bi bi-dash font-18 color-red-dark"></i></a>
                            <input type="number" class="color-theme" min="1" max="99" value="1">
                            <a href="#" class="stepper-add float-end"><i
                                    class="bi bi-plus font-18 color-green-dark"></i></a>
                        </div>
                    </div>
                    <div class="w-100  ms-auto">
                        <a href="#" data-toast="snackbar-cart"
                           class="btn btn-full btn-s font-900 text-uppercase rounded-sm shadow-l bg-blue-dark ms-3">
                            Add to Cart
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="margin-left: 0;margin-right: 0" class="card card-style">
        <div class="content mb-0">
            <div class="d-flex justify-content-center align-items-center mb-2 gap-2">
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <h2>Product Gallery</h2>
                    @if(auth('admin')->check() && auth('admin')->user()->hasAnyRole('admin|developer'))
                        <button
                            data-bs-toggle="offcanvas"
                            data-bs-target="#create-category-modal"
                            class="btn btn-full gradient-green shadow-bg shadow-bg-s btn-s ">
                            Add Images
                        </button>
                    @endif
                </div>
            </div>
            {{-- add images modal--}}
            @if(auth('admin')->check() && auth('admin')->user()->hasAnyRole('admin|developer'))
                <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
                     style="width:100%;max-width :400px" id="create-category-modal">
                    <form class="content" action="{{route('product.image.add')}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <p class="font-24 font-800 mb-3 text-center">Upload Product Images</p>
                        <div class="">
                            <div id="preview" class="preview mb-2"></div>
                            <label for="fileInput" type="button"

                                   class="btn btn-full btn-m text-uppercase font-700 rounded-s upload-file-text bg-highlight">
                                Choose Images
                                <input type="file" id="fileInput" class="upload-file" name="files[]" multiple
                                       accept="image/*">
                            </label>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button
                                onclick="showOverlay()"
                                class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                                Upload
                            </button>
                        </div>
                    </form>
                </div>
            @endif
            <div class="row text-center row-cols-3 mb-0">
                @if($product->getMedia('product_image')->isNotEmpty())
                    @foreach($product->getMedia('product_image') as $key => $image)
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            @if(auth('admin')->check() && auth('admin')->user()->hasAnyRole('admin|developer'))
                                <div class="d-flex flex-wrap justify-content-center align-items-center gap-1">
                                    <form action="{{route('product.image.main')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                        <input type="hidden" name="media_id" value="{{$image->id}}">
                                        <button href="#"
                                                class="btn btn-full btn-s font-900  rounded-sm shadow-l gradient-blue mb-1 pt-2 pb-2">
                                            Main
                                        </button>
                                    </form>
                                    <form action="{{route('product.image.delete')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                        <input type="hidden" name="media_id" value="{{$image->id}}">
                                        <button href="#"
                                                class="btn btn-full btn-s font-900  rounded-sm shadow-l gradient-red mb-1 pt-2 pb-2">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            @endif
                            <a class="col mb-4" data-gallery="gallery-1"
                               href="{{ $image->getUrl() }}"
                               title="{{ $product->name }}">
                                <img src="{{ $product->getMedia('product_thumbnail')->get($key)?->getUrl() ?? '' }}"
                                     data-src="{{ $product->getMedia('product_thumbnail')->get($key)?->getUrl() ?? '' }}"
                                     class="img-fluid rounded-m preload-img"
                                     alt="{{ $product->name }}">
                            </a>
                        </div>
                    @endforeach
                @else
                    @include('frontend.placeholders.product_images')
                @endif
            </div>
        </div>
    </div>
    {{--     video embeding --}}
    <div style="margin-left: 0;margin-right: 0" class="card card-style">
        @if(auth('admin')->check())
            <div class="d-flex justify-content-center align-items-center mt-2 mb-1 gap-2">
                {{--  edit video modal--}}
                <button
                    class=" btn btn-full btn-s font-900  rounded-s shadow-l bg-blue-dark "
                    data-bs-toggle="offcanvas"
                    data-bs-target="#edit_video">
                    @if($product->embed_video)
                        Edit Video
                    @else
                        Add Video
                    @endif
                </button>
                <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
                     style="width:100%;max-width :400px" id="edit_video">
                    <form class="content" action="{{route('product.video.update')}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <div class="d-flex justify-content-start align-items-center ">
                            <i class="bi bi-pencil-fill font-12 disabled"></i>
                            <label for="video" class="color-theme text-center w-100">
                                Edit Video
                                <input type="text" name="video" class="form-control rounded-xs"
                                       id="video"
                                       value=""
                                       required
                                       placeholder="Youtube Video Link">
                            </label>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button
                                onclick="showOverlay()"
                                class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                                Add
                            </button>
                        </div>
                    </form>
                </div>
                @if($product->embed_video)
                    <form action="{{route('product.video.delete')}}" method="post">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$product->id}}">
                        <button
                            class=" btn btn-full btn-s font-900  rounded-s shadow-l bg-red-dark ">
                            Delete Video
                        </button>
                    </form>
                @endif
            </div>
        @endif
        @if($product->embed_video)
            <div class="content">
                <div class="responsive-iframe rounded-s">
                    <iframe class="rounded-s"
                            src="https://www.youtube.com/embed/{{$product->embed_video}}" frameborder="0"
                            allowfullscreen=""></iframe>
                </div>
            </div>
        @endif
    </div>

    <div style="margin-left: 0;margin-right: 0" class="card card-style">
        <div class="content mb-4">
            <h3 class="text-center">Similar Products</h3>
        </div>
        <div class="splide  dynamic-slider slider-dots-under slider-boxed" id="dynamic-slider">
            <div class="splide__track">
                <div class="splide__list">
                    @include('frontend.placeholders.similar_slider_items')
                </div>
            </div>
        </div>
    </div>

@endsection
