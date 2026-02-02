<div class="p-3">
    @if($product->is_present===true)
        Product itself is present
        @else
    @if($presentProducts->isEmpty())
        <p class="text-center">{{ __('No presents available') }}</p>
    @else
        <ul class="list-unstyled">
            @foreach($presentProducts as $presentProduct)
                <li class="mb-3 d-flex align-items-center">
                    <input type="checkbox"
                           id="present_{{$presentProduct->id}}_for_{{$product->id}}"
                           class="form-check-input me-2"
                           @if(in_array($presentProduct->id, $attachedPresentIds)) checked @endif
                           hx-post="{{route('present.toggle')}}"
                           hx-vals='{"product_id": "{{$product->id}}", "present_id": "{{$presentProduct->id}}"}'
                           hx-swap="none">
                    <label for="present_{{$presentProduct->id}}_for_{{$product->id}}" class="form-check-label">
                        @if($presentProduct->getFirstMediaUrl('product_image'))
                            <img src="{{$presentProduct->getFirstMediaUrl('product_image', 'thumbnail')}}"
                                 alt="{{$presentProduct->name}}"
                                 class="img-thumbnail me-2"
                                 style="width: 50px; height: 50px; object-fit: cover;">
                        @endif
                        <span>{{$presentProduct->name}}</span>
                    </label>
                </li>
            @endforeach
        </ul>
    @endif
    @endif
</div>
