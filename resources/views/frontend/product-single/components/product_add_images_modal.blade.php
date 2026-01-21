<div style="margin-left: 0;margin-right: 0" class="row mb-3 mt-1">
    <div class="d-flex justify-content-center align-items-center mb-2 gap-2">
        <div class="d-flex flex-column justify-content-center align-items-center">
            {{--  <h2>Product Gallery</h2> --}}
            <button
                data-bs-toggle="offcanvas"
                data-bs-target="#create-category-modal"
                class="btn btn-full gradient-blue shadow-bg shadow-bg-s btn-s ">
                Add Images
            </button>
        </div>terms
    </div>
    {{-- add images modal --}}

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
                    class="btn btn-full bg-highlight shadow-bg shadow-bg-s mt-4">
                    Upload
                </button>
            </div>
        </form>
    </div>
</div>
