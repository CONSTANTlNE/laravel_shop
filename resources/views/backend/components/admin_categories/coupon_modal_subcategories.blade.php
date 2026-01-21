<button href="#"
        data-bs-toggle="offcanvas"
        data-bs-target="#apply_coupon_subcat{{$subcategory->id}}"
        class="btn btn-full btn-s font-900  rounded-sm shadow-l bg-blue-dark mb-1 pt-2 pb-2">
    {{__('Coupon')}}
</button>

<div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
     style="width:100%;max-width :400px" id="apply_coupon_subcat{{$subcategory->id}}">
    <form class="content" action="{{route('coupon.apply.category')}}" method="post"
          enctype="multipart/form-data">
        @csrf
        <input type="hidden" value="{{$subcategory->slug}}" name="category_slug">
        <input type="hidden" value="{{$subcategory->id}}" name="category_id">
        <p class="font-18 font-800 mb-3 text-center">{{__('Apply Coupon')}}</p>
        <p class="font-18 font-800 mb-3 text-center">{{$subcategory->name}}</p>
        <div class="d-flex justify-content-center">
            <select required name="coupon_id" class="form-select rounded-xs w-auto d-inline">
                <option value="">
                    {{__('Select Coupon')}}
                </option>
                @foreach($coupons as $coupon)
                    <option value="{{$coupon->id}}">
                        {{$coupon->promoter->name}}-{{$coupon->code}}-{{$coupon->discount_percentage}}%
                    </option>
                @endforeach
            </select>
        </div>
        <p class="font-12 color-red-light w-100 text-center mt-2 mb-0">
            {{__('Promo Code will be applied to all products within category !')}}
        </p>
        <div class="d-flex justify-content-center gap-2">
            <button class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                {{__('Apply')}}
            </button>
            <button form="remove_coupon_form{{$category->id}}{{$subcategory->id}}" class="btn btn-full gradient-red shadow-bg shadow-bg-s mt-4">
                {{__('Remove')}}
            </button>
        </div>
    </form>
    <form action="{{route('coupon.remove.category')}}" id="remove_coupon_form{{$category->id}}{{$subcategory->id}}" method="post">
        @csrf
        <input type="hidden" name="category_id" value="{{$subcategory->id}}">
        <input type="hidden" name="category_slug" value="{{$subcategory->slug}}">
    </form>

</div>
