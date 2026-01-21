@foreach($product->getMedia('product_image') as $media)
    <div>
        {{-- main image --}}
        <div class="d-flex flex-column justify-content-center align-items-center mb-2">
            <span>{{__('Main Image')}}</span>
            <form action="{{route('product.image.main')}}" method="post">
                @csrf
                <input type="hidden" name="product_id" value="{{$product->id}}">
                <input type="hidden" name="media_id" value="{{$media->id}}">
                <div class="form-switch ios-switch switch-green switch-l">
                    <input type="checkbox" class="ios-input" id="switch-4crerer{{$media->id}}"
                           @checked($media->main==1) onchange="this.form.submit()">
                    <label class="custom-control-label" for="switch-4crerer{{$media->id}}"></label>
                </div>
            </form>
        </div>
        <div class="d-flex justify-content-center mb-2">
            <form action="{{route('product.image.delete')}}" method="post">
                @csrf
                <input type="hidden" name="media_id" value="{{$media->id}}">
                <button class="btn btn-danger pt-2 pb-2">{{__('Delete')}}</button>
            </form>
        </div>
        <a class="col" data-gallery="gallery-1" target="_blank" href="{{ $media->getUrl() }}"
           title="Vynil and Typerwritter">
            <img src="{{$media->getUrl('thumbnail')}}" data-src="{{asset($media->getUrl('thumbnail'))}}"
                 class="preload-img img-fluid rounded-l" alt="img">
{{--            <p class="font-600 pb-3">Writer</p>--}}
        </a>
    </div>
@endforeach
