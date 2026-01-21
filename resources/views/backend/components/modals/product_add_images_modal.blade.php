<div style="margin-left: 0;margin-right: 0" class="row mb-3 mt-1">
    <div class="d-flex justify-content-center align-items-center mb-2 gap-2">
        <div class="d-flex flex-column justify-content-center align-items-center">
            {{--  <h2>Product Gallery</h2> --}}
            <button
                data-bs-toggle="offcanvas"
                data-bs-target="#add_images_{{$product->id}}"
                class="btn btn-full gradient-blue shadow-bg shadow-bg-s btn-s pb-2 pt-2">
                {{__('Add Images')}}
            </button>
        </div>
    </div>

    {{-- add images modal --}}
    <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
         style="width:100%;max-width :400px" id="add_images_{{$product->id}}">
        <form class="content" action="{{route('product.image.add')}}" method="post"
              enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="product_id" value="{{$product->id}}">
            <p class="font-24 font-800 mb-3 text-center">{{$product->name}}</p>
            <div class="">
                <div class="preview mb-2"></div>
                <label for="fileInput_products_{{$product->id}}" type="button"
                       class="btn btn-full btn-m text-uppercase font-700 rounded-s upload-file-text bg-highlight">
                    {{__('Choose Images')}}
                    <input type="file" id="fileInput_products_{{$product->id}}" class="upload-file" name="files[]" multiple
                           accept="image/*">
                </label>
            </div>
            <div class="d-flex justify-content-center">
                <button
                    onclick="showOverlay()"
                    class="btn btn-full bg-highlight shadow-bg shadow-bg-s mt-4">
                    {{__('Upload')}}
                </button>
            </div>
        </form>
    </div>
</div>
