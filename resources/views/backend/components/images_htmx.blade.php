@foreach($product->getMedia('product_image') as $media)
    <div class="mt-2" id="delete_media{{$media->id}}">
        <span>{{__('Main Image')}}</span>
        {{-- main image --}}
        <div class="d-flex flex-wrap justify-content-center gap-2">
            <div class="d-flex flex-column justify-content-center align-items-center mb-2">
                <form
                      action="{{route('product.image.main')}}"
{{--                      hx-post="{{route('product.image.main')}}"--}}
{{--                      hx-target="#htmx_messages"--}}
                      method="post">
                    @csrf
                    <input type="hidden" name="product_id" value="{{$product->id}}">
                    <input type="hidden" name="model_id" value="{{$media->model_id}}">
                    <input type="hidden" name="media_id" value="{{$media->id}}">
                    <div class="form-switch ios-switch switch-green switch-l">
                        <input type="checkbox" class="ios-input" id="switch-4crerer{{$media->id}}"
                               @checked($media->main==1)
                               onchange="this.form.submit()"
{{--                               hx-post="{{route('product.image.main')}}" --}}
{{--                               hx-target="#htmx_messages"--}}
                        >
                        <label class="custom-control-label" for="switch-4crerer{{$media->id}}"></label>
                    </div>
                </form>
            </div>
            <div class="d-flex justify-content-center mb-2">
                <form
                    {{--                      action="{{route('product.image.delete')}}" --}}
                    hx-post="{{route('product.image.delete')}}"
                    hx-target="#htmx_messages"
                    hx-on::after-request="
                        if(event.detail.successful) {
                            document.getElementById(`delete_media{{$media->id}}`).remove()
                        }
                      "
                    method="post">
                    @csrf
                    <input type="hidden" name="media_id" value="{{$media->id}}">
                    <button class="btn btn-danger pt-2 pb-2">{{__('Delete')}}</button>
                </form>
            </div>
        </div>
        <a class="col" data-gallery="gallery-1" target="_blank" href="{{ $media->getUrl() }}"
           title="Vynil and Typerwritter">
            <img src="{{$media->getUrl('thumbnail')}}" data-src="{{asset($media->getUrl('thumbnail'))}}"
                 class="preload-img img-fluid rounded-l" alt="img">
            {{--            <p class="font-600 pb-3">Writer</p>--}}
        </a>
    </div>
@endforeach
