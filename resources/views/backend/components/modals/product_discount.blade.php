<button href="#"
        data-bs-toggle="offcanvas"
        data-bs-target="#apply_discount_{{$product->id}}"
        class="btn btn-full btn-s font-900  rounded-sm shadow-l {{$product->discounted==1 ? 'bg-green-dark' : 'bg-blue-dark' }}  mb-1 pt-2 pb-2">
    @if($product->discounted==1)
        {{__('Discounted')}}
    @else
        {{__('Apply Discount')}}
    @endif
</button>

<div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
     style="width:100%;max-width :400px" id="apply_discount_{{$product->id}}">
    @if($product->discounted==1)
        {{--  remove discount --}}
        <form class="content" action="{{route('discount.remove.product')}}"
              method="post"
              enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{$product->id}}" name="product_id">
            <input type="hidden" value="{{$product->discount->id}}" name="discount_id">
            <p class=" font-18 font-800 mb-3">Remove Discount {{$product->name}}</p>
            <div class="d-flex justify-content-center form-check form-check-custom">
                <input class="form-check-input" name="increase_price"
                       @checked($product->discount->increase_price==1)
                       type="checkbox" value="" id="increase_price{{$product->id}}">
                <label class="form-check-label" for="increase_price{{$product->id}}">
                    Increase Price after deadline
                </label>
                <i class="is-checked color-green-dark bi bi-check-square"
                   style="left:100px"></i>
                <i class="is-unchecked color-red-dark bi bi-x-square"
                   style="left:100px"></i>
            </div>
            <div class="d-flex justify-content-center">
                <button class="btn btn-full gradient-red shadow-bg shadow-bg-s mt-4">
                    Remove Discount
                </button>
            </div>
        </form>
    @else
        {{-- apply discount --}}
        <form class="content" action="{{route('discount.apply.product')}}" method="post"
              enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{$product->id}}" name="product_id">
            <p class="font-18 font-800 mb-3">Apply Discount to {{$product->name}}</p>

            @foreach($discounts as $discount)
                <div class="form-check form-check-custom">
                    <input class="form-check-input" type="checkbox" name="discount_id"
                           value="{{$discount->id}}"
                           id="c2{{$discount->id}}{{$product->id}}">
                    <label class="form-check-label"
                           for="c2{{$discount->id}}{{$product->id}}">
                        {{$discount->discount_percentage}}% Valid
                        till: {{$discount->valid_till}}
                    </label>
                    <i class="is-checked color-green-dark bi bi-check-circle"></i>
                    <i class="is-unchecked color-highlight bi bi-circle"></i>
                </div>
            @endforeach

            <div class="d-flex justify-content-center">
                <button class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                    Apply
                </button>
            </div>
        </form>
    @endif
</div>
