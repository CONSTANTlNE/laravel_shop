<button href="#"
        data-bs-toggle="offcanvas"
        data-bs-target="#apply_coupon_{{$product->id}}"
        class="btn btn-full btn-s font-900  rounded-sm shadow-l {{$product->coupon_id !=null ? 'bg-green-dark' : 'bg-blue-dark' }}  mb-1 pt-2 pb-2">

    @if($product->coupon_id !=null)
        {{(__('Coupon'))}}
    @else
        {{__('Apply Coupon')}}
    @endif

</button>
@if($product->coupon_id !=null)
    <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
         style="width:100%;max-width :400px" id="apply_coupon_{{$product->id}}">
        <form class="content" action="{{route('coupon.remove.product')}}" method="post"
              enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{$product->id}}" name="product_id">
            <p class="font-18 font-800 mb-3 text-center">Remove Coupon
                to {{$product->name}}</p>
            @foreach($coupons as $coupon)
                @if($coupon->id===$product->coupon_id)
                    <div class="form-check form-check-custom">
                        <input class="form-check-input" type="checkbox" name="coupon_id"
                               value="{{$coupon->id}}"
                               checked
                               id="c2{{$coupon->id}}{{$product->id}}">
                        <label class="form-check-label"
                               for="c2{{$coupon->id}}{{$product->id}}">
                            {{$coupon->code}} - {{$coupon->promoter->name}}
                            - {{$coupon->valid_till}}
                        </label>
                        <i class="is-checked color-green-dark bi bi-check-circle"></i>
                        <i class="is-unchecked color-highlight bi bi-circle"></i>
                    </div>
                @endif
            @endforeach

            <div class="d-flex justify-content-center">
                <button class="btn btn-full gradient-red shadow-bg shadow-bg-s mt-4">
                    Remove Coupon
                </button>
            </div>
        </form>
    </div>
@else
    <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
         style="width:100%;max-width :400px" id="apply_coupon_{{$product->id}}">
        <form class="content" action="{{route('coupon.apply.product')}}" method="post"
              enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{$product->id}}" name="product_id">
            <p class="font-18 font-800 mb-3 text-center">Apply Coupon
                to {{$product->name}}</p>
            @foreach($coupons as $coupon)
                <div class="form-check form-check-custom">
                    <input class="form-check-input" type="checkbox" name="coupon_id"
                           value="{{$coupon->id}}"
                           id="c2{{$coupon->id}}{{$product->id}}">
                    <label class="form-check-label"
                           for="c2{{$coupon->id}}{{$product->id}}">
                        {{$coupon->code}} - {{$coupon->promoter->name}}
                        - {{$coupon->valid_till}}
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
    </div>
@endif
