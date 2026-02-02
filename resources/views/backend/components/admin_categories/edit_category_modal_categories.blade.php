<a href="#"
   data-bs-toggle="offcanvas"
   data-bs-target="#edit-category-modal_{{$category->id}}"
   class="list-group-item">
    <i class="bi bi-pencil-square color-blue-dark font-30"></i>
</a>
<div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
     style="width:100%;max-width :400px" id="edit-category-modal_{{$category->id}}">
    <form class="content" action="{{route('category.update')}}" method="post"
          enctype="multipart/form-data">
        @csrf
        <input type="hidden" value="{{$category->id}}" name="category_id">
        <p class="font-24 font-800 mb-3 text-center">Edit Category</p>
        @foreach($locales as $locale)
            <div class="form-custom mb-3 form-floating">
                <input type="text" name="category_name_{{$locale->abbr}}"
                       class="form-control rounded-xs"
                       id="c1{{$locale->abbr}}"
                       @required($locale->main==1)
                       value="{{$category->getTranslation('name',$locale->abbr)}}"
                       placeholder="Category Name"/>
                <label for="c1{{$locale->abbr}}"
                       class="color-theme">Name {{$locale->language}} </label>
                <span>({{_('required')}})</span>
            </div>
        @endforeach
        <div class="form-check form-check-custom  mb-2 justify-content-center">
            <input class="form-check-input"
                   name="for_main"
                   type="checkbox"
                   @checked($category->categoryOrder?->active==1)
                   id="c2a2{{$category->slug}}">
            <label class="form-check-label" for="c2a2{{$category->slug}}">
                {{__('Show on Main Page')}}
            </label>
            <i class="is-checked color-green-dark bi bi-check-square"></i>
            <i class="is-unchecked color-red-dark bi bi-x-square"></i>
        </div>
        <div class="">
            <div id="previewEdit_{{$category->id}}" class="preview"></div>
            <label for="fileInputEdit_{{$category->name}}" type="button"
                   class="btn btn-full btn-m text-uppercase font-700 rounded-s upload-file-text bg-highlight">
                Upload New Image
                <input type="file"
                       id="fileInputEdit_{{$category->name}}"
                       class="upload-file"
                       name="files[]" multiple
                       accept="image/*">
            </label>
        </div>
        <div class="d-flex justify-content-center">
            <button class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                Update
            </button>
        </div>
    </form>
</div>
