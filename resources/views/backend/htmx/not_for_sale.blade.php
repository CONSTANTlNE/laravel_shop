<button type="button"
        class="btn btn-sm @if($product->for_sale) btn-success @else btn-danger @endif"
        hx-post="{{route('product.for_sale')}}"
        hx-swap="outerHTML"
        {{--                                            hx-target="#htmx_messages"--}}
        hx-include="[name='product_id']">
    <span>{{ $product->for_sale ? __('For Sale') : __('Not For Sale') }}</span>
</button>
