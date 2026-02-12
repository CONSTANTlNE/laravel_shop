<button href="#"
        data-bs-toggle="offcanvas"
        data-bs-target="#price_update_{{$product->id}}"
        class="btn btn-full btn-s font-900 rounded-sm shadow-l bg-blue-dark mb-1 pt-2 pb-2">
    {{$product->price}}
</button>

<div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
     style="width:100%;max-width:400px" id="price_update_{{$product->id}}">
    <form class="content" action="{{route('product.price.update')}}" method="post">
        @csrf
        <input type="hidden" value="{{$product->id}}" name="product_id">

        <p class="font-18 font-800 mb-3">Update Price - {{$product->name}}</p>

        <div class="input-style input-style-always-active has-borders has-icon validate-field mb-4 text-center d-flex justify-content-center ">
            <i class="fa fa-dollar-sign"></i>
            <input type="number"
                   style="max-width: 60px"
                   class="form-control validate-text"
                   id="price_{{$product->id}}"
                   name="price"
                   placeholder="Enter new price"
                   value="{{$product->price}}"
                   step="0.01"
                   min="0"
                   required>
        </div>
        <label for="price_{{$product->id}}" class="color-highlight">{{__('Price')}}</label>
        <i class="fa fa-times disabled invalid color-red-dark"></i>
        <i class="fa fa-check disabled valid color-green-dark"></i>
        <em>({{__('required')}})</em>
        <div class="d-flex justify-content-center gap-2 mt-2">

            <button type="submit" class="btn btn-full gradient-green shadow-bg shadow-bg-s">
                {{__('Update')}}
            </button>

            <button type="button" data-bs-dismiss="offcanvas"
                    class="btn btn-full gradient-red shadow-bg shadow-bg-s mt-2">
                {{__('Cancel')}}
            </button>

        </div>
    </form>
</div>
