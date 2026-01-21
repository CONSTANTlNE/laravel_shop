<div class="d-flex justify-content-center align-items-center">
    <form class="col-12" style="max-width: 500px;" method="post"
          action="{{route('product.feature.store')}}">
        @csrf
        <input type="hidden" name="product_id" value="{{$product->id}}">
        <p class="text-center">Add Product Features</p>
        @foreach($locales as $locale)
            <div class="d-flex justify-content-center gap-2 flex-wrap flex-sm-nowrap">
                <div class="form-custom mb-3 form-floating" style="width: 100%">
                    <input type="text"
                           name="feature_name_{{$locale->abbr}}"
                           class="form-control rounded-xs w-full"
                           id="c1{{$locale->abbr}}"
                           value="{{old('feature_name_'.$locale->abbr)}}"
                           placeholder="Prodct Name"/>
                    <label for="c1{{$locale->abbr}}"
                           class="color-theme">Feature Name {{$locale->language}}
                    </label>
                </div>
                <div class="form-custom mb-3 form-floating" style="width: 100%">
                    <input type="text"
                           name="feature_text_{{$locale->abbr}}"
                           class="form-control rounded-xs w-full"
                           id="c2{{$locale->abbr}}"
                           value="{{old('feature_text_'.$locale->abbr)}}"
                           placeholder="Prodct Name"/>
                    <label for="c1{{$locale->abbr}}"
                           class="color-theme">Feature Text {{$locale->language}}
                    </label>
                </div>
            </div>
        @endforeach
        <div class="d-flex justify-content-center align-items-center">
            <button href="#"
                    onclick="showOverlay()"
                    class="btn btn-full btn-s font-900  rounded-sm shadow-l bg-blue-dark mb-1 pt-2 pb-2">
                Add Feature
            </button>
        </div>
    </form>
</div>
