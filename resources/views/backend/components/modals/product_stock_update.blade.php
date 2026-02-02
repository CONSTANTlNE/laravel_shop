<button href="#"
        data-bs-toggle="offcanvas"
        data-bs-target="#stock_update_{{$product->id}}"
        class="btn btn-full btn-s font-900 rounded-sm shadow-l bg-blue-dark mb-1 pt-2 pb-2">
    {{$product->stock}}
</button>

<div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
     style="width:100%;max-width:400px" id="stock_update_{{$product->id}}">
    <form class="content" action="{{route('product.stock.update')}}" method="post">
        @csrf
        <input type="hidden" value="{{$product->id}}" name="product_id">

        <p class="font-18 font-800 mb-3">Update Stock - {{$product->name}}</p>

        <div class="input-style input-style-always-active has-borders has-icon validate-field mb-4">
            <i class="fa fa-boxes"></i>
            <input type="number"
                   class="form-control validate-text"
                   id="stock_{{$product->id}}"
                   name="stock"
                   placeholder="Enter stock quantity"
                   value="{{$product->stock}}"
                   step="1"
                   min="0"
                   required>
            <label for="stock_{{$product->id}}" class="color-highlight">Stock</label>
            <i class="fa fa-times disabled invalid color-red-dark"></i>
            <i class="fa fa-check disabled valid color-green-dark"></i>
            <em>(required)</em>
        </div>

        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                Update Stock
            </button>
        </div>

        <div class="d-flex justify-content-center">
            <button type="button" data-bs-dismiss="offcanvas" class="btn btn-full gradient-red shadow-bg shadow-bg-s mt-2">
                {{__('Cancel')}}
            </button>
        </div>
    </form>
</div>
