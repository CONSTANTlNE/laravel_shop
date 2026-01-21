<div class="d-flex justify-content-center">

<button href="#"
        data-bs-toggle="offcanvas"
        data-bs-target="#apply_discount_{{$category->id}}"
        class="btn btn-full btn-s font-900  rounded-sm shadow-l bg-blue-dark mb-1 pt-2 pb-2">
    Discount
</button>
</div>
<div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
     style="width:100%;max-width :400px" id="apply_discount_{{$category->id}}">
    <form class="content" action="{{route('discount.apply.category')}}" method="post"
          enctype="multipart/form-data">
        @csrf
        <input type="hidden" value="{{$category->slug}}" name="category_slug">
        <input type="hidden" value="{{$category->id}}" name="category_id">
        <p class="font-18 font-800 mb-3">Apply Discount to {{$category->name}}</p>
        @foreach($discounts as $discount)
            <div class="form-check form-check-custom">
                <input class="form-check-input" type="checkbox" name="discount_id"
                       value="{{$discount->id}}"
                       id="c2category{{$discount->id}}{{$category->id}}">
                <label class="form-check-label"
                       for="c2category{{$discount->id}}{{$category->id}}">
                    {{$discount->discount_percentage}}%
                    {{__('Valid till')}}: {{$discount->valid_till}}
                </label>
                <i class="is-checked color-green-dark bi bi-check-circle"></i>
                <i class="is-unchecked color-highlight bi bi-circle"></i>
            </div>
        @endforeach
        <span class="font-11 color-red-light">Discount will be applied to all products within category !</span>
        <div class="d-flex justify-content-center">
            <button onclick="showOverlay()"
                    class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                Apply
            </button>
        </div>
    </form>
</div>
