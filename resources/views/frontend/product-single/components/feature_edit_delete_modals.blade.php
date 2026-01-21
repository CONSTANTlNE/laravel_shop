<button style="all:unset;cursor:pointer"
        class="mb-1"
        data-bs-toggle="offcanvas"
        data-bs-target="#edit_feature{{$feature_index}}">
    <i class="bi bi-pencil-square color-blue-dark font-18"></i>
</button>
{{--  edit feature modal--}}
<div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
     style="width:100%;max-width :400px" id="edit_feature{{$feature_index}}">
    <form class="content" action="{{route('product.feature.update')}}" method="post"
          enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="feature_id" value="{{$feature->id}}">
        <p class="font-24 font-800 mb-3 text-center">Edit Feature</p>
        @foreach($locales as $locale)
            <div class="d-flex justify-content-center gap-2 flex-wrap flex-sm-nowrap">
                <div class="form-custom mb-3 form-floating" style="width: 100%">
                    <input type="text"
                           name="feature_name_{{$locale->abbr}}"
                           class="form-control rounded-xs"
                           id="c1{{$locale->abbr}}"
                           value="{{$feature->getTranslation('feature_name',$locale->abbr)}}"
                           placeholder="Feature Name"/>
                    <label for="c1{{$locale->abbr}}"
                           class="color-theme">Feature Name {{$locale->language}}
                    </label>
                </div>
                <div class="form-custom mb-3 form-floating" style="width: 100%">
                    <input type="text"
                           name="feature_text_{{$locale->abbr}}"
                           class="form-control rounded-xs"
                           id="c2{{$locale->abbr}}"
                           value="{{$feature->getTranslation('feature_text',$locale->abbr)}}"
                           placeholder="Text"/>
                    <label for="c1{{$locale->abbr}}"
                           class="color-theme">Feature Text {{$locale->language}}
                    </label>
                </div>
            </div>
        @endforeach

        <div class="d-flex justify-content-center">
            <button
                onclick="showOverlay()"
                class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                Update
            </button>
        </div>
    </form>
</div>

<form action="{{route('product.feature.delete')}}" method="post">
    @csrf
    <input type="hidden" name="feature_id" value="{{$feature->id}}">
    <button style="all:unset;cursor:pointer"
            class="mb-1"
            data-bs-toggle="offcanvas"
            data-bs-target="#delete_feature{{$feature_index}}">
        <i class="bi bi-trash color-red-dark font-18"></i>
    </button>
</form>
