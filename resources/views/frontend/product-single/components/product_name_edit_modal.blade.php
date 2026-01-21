<button
    style="all:unset;cursor:pointer"
    class=" mb-2"
    data-bs-toggle="offcanvas"
    data-bs-target="#edit_name">
    <i class="bi bi-pencil-square color-blue-dark font-20"></i>
    Edit Name
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
