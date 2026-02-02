<button href="#"
        data-bs-toggle="offcanvas"
        data-bs-target="#present_modal_{{$product->id}}"
        hx-get="{{route('present.products', ['product_id' => $product->id])}}"
        hx-target="#present_target_{{$product->slug}}"
        hx-indicator="#indicator_presents_{{$product->slug}}"
        hx-on::before-request="document.getElementById('present_target_{{$product->slug}}').innerHTML = '';"
        class="btn btn-full btn-s font-900  rounded-sm shadow-l bg-blue-dark  mb-1 pt-2 pb-2">
        {{__('Presents')}}
</button>

<div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
     style="width:100%;max-width :400px" id="present_modal_{{$product->id}}">
       <div id="indicator_presents_{{$product->slug}}"  class="htmx-indicator"></div>
       <div id="present_target_{{$product->slug}}" >

       </div>
</div>
