<div class="d-flex justify-content-center gap-3 mb-3">
    <button
        data-bs-toggle="offcanvas"
        data-bs-target="#create-subcat_product-modal{{$category->id}}"
        onclick="document.getElementById('category_sku_{{$category->id}}').value=generateSKU()"
        class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-2">
        {{__('Add Product')}}
    </button>
    <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
         style="width:100%;max-width :400px" id="create-subcat_product-modal{{$category->id}}">
        <form class="content" action="{{route('product.store')}}" method="post"
              enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="category_id" value="{{$category->id}}">
            <input type="hidden" name="category_slug" value="{{$category->slug}}">
            <p class="font-24 font-800 mb-3 text-center">
                {{__('Add Product')}}
            </p>
            <p class="font-24 font-800 mb-3 text-center">
                ({{$category->name}})
            </p>
            <div class="d-flex gap-3 mb-3">
                <label for="sku"
                       style="width: 100%"
                       class="color-theme text-center">SKU
                    <input type="text"
                           name="sku"
                           class="form-control rounded-xs"
                           id="category_sku_{{$category->id}}"
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
                        <span>({{__('required')}})</span>
                    @endif
                </div>
            @endforeach
            <div class="form-custom mb-3 form-floating">
                <input type="text" name="video"
                       class="form-control rounded-xs"
                       id="video"
                       placeholder="Youtube Video Link"/>
                <label for="video"
                       class="color-theme">{{__('Video Link')}}</label>
            </div>
            <div class="">
                <div id="preview" class="preview mb-2"></div>
                <label for="fileInput_products{{$category->name}}" type="button"
                       class="btn btn-full btn-m text-uppercase font-700 rounded-s upload-file-text bg-highlight">
                    {{__('Upload Images')}}
                    <input type="file" id="fileInput_products{{$category->name}}" class="upload-file" name="files[]"
                           multiple
                           accept="image/*">
                </label>
            </div>
            <div class="d-flex justify-content-center">
                <button class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                    {{__('Create')}}
                </button>
            </div>
        </form>
    </div>
</div>
