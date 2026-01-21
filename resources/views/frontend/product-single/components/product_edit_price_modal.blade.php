<div class="d-flex justify-content-start ">
    <button
        style="all:unset;cursor:pointer"
        class="mb-2"
        data-bs-toggle="offcanvas"
        data-bs-target="#edit_price">
        <i class="bi bi-pencil-square color-blue-dark font-18"></i>
        Edit Price
    </button>

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
