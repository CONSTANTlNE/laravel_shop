<a style="min-width: 100px;"
   hx-post="{{route('product.htmx.images')}}"
   hx-vals='{"_token":"{{csrf_token()}}","product_id":"{{$product->id}}"}'
   hx-target="#gallery_target_{{$product->id}}"
   hx-indicator="#gallery_{{$product->slug}}"
   hx-on::before-request="document.getElementById('gallery_target_{{$product->id}}').innerHTML = '';"
   href="#"
   data-bs-toggle="offcanvas"
   data-bs-target="#gallery_product_{{$product->id}}"
   class="list-group-item text-center mb-1">
    <i class="bi bi-image color-magenta-dark font-40"></i>
{{--    <span>{{__('Images')}}</span>--}}
</a>
<div style="height: 94%;" class="offcanvas offcanvas-bottom rounded-m offcanvas-detached"
     id="gallery_product_{{$product->id}}">
    <div class="content" style="z-index: 1041!important;">
        <div class="d-flex pb-2">
            <div class="align-self-center">
{{--                <h5 class="mb-n2 font-12 color-highlight font-700 text-uppercase pt-1">Just tap to</h5>--}}
{{--                <h1 class="font-800 font-22">Show Gallery</h1>--}}
            </div>
            <div class="align-self-center ms-auto">
                <a href="#" data-bs-dismiss="offcanvas" class="icon icon-m"><i
                        class="bi bi-x-circle-fill color-red-dark font-30 me-n4"></i></a>
            </div>
        </div>
        <div class="divider"></div>
        <div id="gallery_{{$product->slug}}"  class="htmx-indicator"></div>
        <div class="row text-center row-cols-3 mb-n3" id="gallery_target_{{$product->id}}">

        </div>
    </div>
</div>
