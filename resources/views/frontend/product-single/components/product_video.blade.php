
<div class="d-flex justify-content-center align-items-center mt-2 mb-1 gap-2">
    {{--  edit video modal--}}
    <button
        class=" btn btn-full btn-s font-900  rounded-s shadow-l bg-blue-dark "
        data-bs-toggle="offcanvas"
        data-bs-target="#edit_video">
        @if($product->embed_video)
            {{__('Edit Video')}}
        @else
            {{__('Add Video')}}
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
                    {{__('Edit Video')}}
                    <input type="text" name="video" class="form-control rounded-xs"
                           id="video"
                           value=""
                           required
                           placeholder="Youtube Video Link">
                </label>
            </div>
            <div class="d-flex justify-content-center">
                <button
{{--                    onclick="showOverlay()"--}}
                    class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                    {{__('Add')}}
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
                {{__('Delete Video')}}
            </button>
        </form>
    @endif
</div>
