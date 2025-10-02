@extends('frontend.components.layout')

@section('front-categories')
    {{--   create category modal --}}
    @if(auth('admin')->check())
        <div class="d-flex justify-content-center gap-3 mb-3">
            <button
                data-bs-toggle="offcanvas"
                data-bs-target="#create-category-modal"
                class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-2">
                Add Category
            </button>
            <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
                 style="width:100%;max-width :400px" id="create-category-modal">
                <form class="content" action="{{route('category.store')}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <p class="font-24 font-800 mb-3 text-center">Create Category</p>
                    @foreach($locales as $locale)
                        <div class="form-custom mb-3 form-floating">
                            <input type="text" name="category_name_{{$locale->abbr}}"
                                   class="form-control rounded-xs"
                                   id="c1{{$locale->abbr}}"
                                   @required($locale->main==1)
                                   value="{{old('category_name_'.$locale->abbr)}}"
                                   placeholder="Category Name"/>
                            <label for="c1{{$locale->abbr}}"
                                   class="color-theme">Name {{$locale->language}} </label>
                            <span>(required)</span>
                        </div>
                    @endforeach
                    <div class="form-check form-check-custom  mb-2">
                        <input class="form-check-input"
                               name="for_main"
                               type="checkbox"
                               checked
                               id="c2a2">
                        <label class="form-check-label" for="c2a2">Show on Main Page</label>
                        <i class="is-checked color-green-dark bi bi-check-square"></i>
                        <i class="is-unchecked color-red-dark bi bi-x-square"></i>
                    </div>
                    <div class="">
                        <div id="preview" class="preview"></div>
                        <label for="fileInput" type="button"
                               class="btn btn-full btn-m text-uppercase font-700 rounded-s upload-file-text bg-highlight">
                            Upload Image
                            <input type="file" id="fileInput" class="upload-file" name="files[]" multiple
                                   accept="image/*">
                        </label>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
    {{--  categories grid--}}
    <div class="card card-style mx-0">
        <div class="content">
            <h2 class="text-center mb-3">All Categories</h2>
            <div class="row mb-0 justify-content-center">
                @foreach($categories as $category)
                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        @if(auth('admin')->check())
                            <div class="d-flex justify-content-center gap-4 mb-1">
                                <a href="#"
                                   data-bs-toggle="offcanvas"
                                   data-bs-target="#edit-category-modal_{{$category->id}}"
                                   class="list-group-item">
                                    <i class="bi bi-pencil-square color-blue-dark font-18"></i>
                                </a>
                                {{--  edit category modal --}}
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
                                                <span>(required)</span>
                                            </div>
                                        @endforeach
                                        <div class="d-flex justify-content-center gap-3 mb-3">
                                            <div class="form-check form-check-custom  mb-2">
                                                <input class="form-check-input"
                                                       name="for_main"
                                                       type="checkbox"
                                                       @checked($category->categoryOrder?->active==1)
                                                       id="c2a2{{$category->slug}}">
                                                <label class="form-check-label" for="c2a2{{$category->slug}}">
                                                    Show on Main Page
                                                </label>
                                                <i class="is-checked color-green-dark bi bi-check-square"></i>
                                                <i class="is-unchecked color-red-dark bi bi-x-square"></i>
                                            </div>
                                            <div class="d-flex justify-content-center gap-3">
                                                <label class="form-check-label">
                                                    Order
                                                </label>
                                                <select name="order" id=""
                                                        style="width: 70px;"
                                                        class="form-select rounded-xs px-1">
                                                    @for ($i = 1; $i <= $categoriesCount; $i++)
                                                    <option @selected($category->order==$i)
                                                            value="{{$i}}">
                                                        {{$i}}
                                                    </option>
                                                    @endfor
                                                </select>
                                            </div>
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
                                {{--  delete category modal --}}
                                <a href="#" data-bs-toggle="offcanvas"
                                   data-bs-target="#delete-category-modal_{{$category->id}}" class="list-group-item">
                                    <i class="bi bi-trash color-red-dark font-18"></i>
                                </a>
                                <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
                                     style="width:100%;max-width :400px" id="delete-category-modal_{{$category->id}}">
                                    <form class="content" action="{{route('category.delete')}}" method="post"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="{{$category->id}}" name="category_id">
                                        <p class="font-24 font-800 mb-3 text-center">Delet Category {{$category->name}}
                                            ?</p>

                                        <div class="d-flex justify-content-center gap-4">
                                            <button type="button" data-bs-dismiss="offcanvas"
                                                    class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                                                Cancel
                                            </button>
                                            <button class="btn btn-full gradient-red shadow-bg shadow-bg-s mt-4">
                                                Delete
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                {{--  add subcategory modal --}}
                                <a href="#" data-bs-toggle="offcanvas"
                                   data-bs-target="#add-subcategory-modal_{{$category->id}}" class="list-group-item">
                                    <i class="bi bi-plus-circle color-blue-dark font-19"></i>
                                </a>
                                <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
                                     style="width:100%;max-width :400px" id="add-subcategory-modal_{{$category->id}}">
                                    <form class="content" action="{{route('subcategory.store')}}" method="post"
                                          enctype="multipart/form-data">
                                        <input type="hidden" name="category_id" value="{{$category->id}}">
                                        @csrf
                                        <input type="hidden" value="{{$category->id}}" name="category_id">
                                        <p class="font-24 font-800 mb-3 text-center">Add Subcategory to
                                            : {{$category->name}}</p>
                                        @foreach($locales as $locale)
                                            <div class="form-custom mb-3 form-floating">
                                                <input type="text" name="category_name_{{$locale->abbr}}"
                                                       class="form-control rounded-xs"
                                                       id="c16{{$locale->abbr}}"
                                                       @required($locale->main==1)
                                                       value=""
                                                       placeholder="SubCategory Name"/>
                                                <label for="c16{{$locale->abbr}}"
                                                       class="color-theme">SubCategory
                                                    Name {{$locale->language}} </label>
                                                <span>(required)</span>
                                            </div>
                                        @endforeach
                                        <div class="form-check form-check-custom  mb-2">
                                            <input class="form-check-input"
                                                   name="for_main"
                                                   type="checkbox"
                                                   checked
                                                   id="c2a2">
                                            <label class="form-check-label" for="c2a2">Show on Main Page</label>
                                            <i class="is-checked color-green-dark bi bi-check-square"></i>
                                            <i class="is-unchecked color-red-dark bi bi-x-square"></i>
                                        </div>
                                        <div class="">
                                            <div id="previewEdit_subcat_{{$category->id}}" class="preview"></div>
                                            <label for="fileInputEdit_subcat_{{$category->name}}" type="button"
                                                   class="btn btn-full btn-m text-uppercase font-700 rounded-s upload-file-text bg-highlight">
                                                Upload Image
                                                <input type="file"
                                                       id="fileInputEdit_subcat_{{$category->name}}"
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
                            </div>
                        @endif
                        <a href="{{route('category.single',$category->slug)}}">
                            <div class="card card-style custom-card m-0  bg-333"
                                 data-card-height="140"
                                 @if($category->getMedia('category_thumbnail')->first())
                                     style="height: 140px; background-image: url({{$category->getMedia('category_thumbnail')->first()?->getUrl()}})"
                                     @else
                                       style="height: 140px; background-image: url({{asset('defaults/default_placeholder.png')}})"
                                 @endif
                                 >
                            </div>
                            <h5 class="font-600 font-16 line-height-sm pt-3 text-center">
                                {{$category->name}}
                            </h5>
                        </a>
                    </div>
                @endforeach
                @if($categories->isEmpty())
                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <div class="card card-style custom-card m-0 bg-21" data-card-height="140"
                             style="height: 140px;"></div>
                        <h5 class="font-600 font-16 line-height-sm pt-3 text-center">
                            Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip M9X
                        </h5>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <div class="card card-style custom-card m-0 bg-21" data-card-height="140"
                             style="height: 140px;"></div>
                        <h5 class="font-600 font-16 line-height-sm pt-3 text-center">
                            Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip M9X
                        </h5>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <div class="card card-style custom-card m-0 bg-21" data-card-height="140"
                             style="height: 140px;"></div>
                        <h5 class="font-600 font-16 line-height-sm pt-3 text-center">
                            Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip M9X
                        </h5>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <div class="card card-style custom-card m-0 bg-21" data-card-height="140"
                             style="height: 140px;"></div>
                        <h5 class="font-600 font-16 line-height-sm pt-3 text-center">
                            Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip M9X
                        </h5>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <div class="card card-style custom-card m-0 bg-21" data-card-height="140"
                             style="height: 140px;"></div>
                        <h5 class="font-600 font-16 line-height-sm pt-3 text-center">
                            Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip M9X
                        </h5>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <div class="card card-style custom-card m-0 bg-21" data-card-height="140"
                             style="height: 140px;"></div>
                        <h5 class="font-600 font-16 line-height-sm pt-3 text-center">
                            Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip M9X
                        </h5>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <div class="card card-style custom-card m-0 bg-21" data-card-height="140"
                             style="height: 140px;"></div>
                        <h5 class="font-600 font-16 line-height-sm pt-3 text-center">
                            Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip M9X
                        </h5>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <div class="card card-style custom-card m-0 bg-21" data-card-height="140"
                             style="height: 140px;"></div>
                        <h5 class="font-600 font-16 line-height-sm pt-3 text-center">
                            Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip M9X
                        </h5>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <div class="card card-style custom-card m-0 bg-21" data-card-height="140"
                             style="height: 140px;"></div>
                        <h5 class="font-600 font-16 line-height-sm pt-3 text-center">
                            Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip M9X
                        </h5>
                    </div>
                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <div class="card card-style custom-card m-0 bg-21" data-card-height="140"
                             style="height: 140px;"></div>
                        <h5 class="font-600 font-16 line-height-sm pt-3 text-center">
                            Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip M9X
                        </h5>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        /* Uniform preview grid */
        .preview {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 10px;
        }

        .preview-item {
            position: relative;
            width: 100%;
            aspect-ratio: 1 / 1; /* keep square tiles */
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            overflow: hidden;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .preview-img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* makes all images same visual size */
            display: block;
        }

        .preview-file {
            padding: 8px;
            font-size: 12px;
            text-align: center;
            color: #333;
        }

        .remove-btn {
            position: absolute;
            top: 4px;
            right: 4px;
            border: none;
            background: rgba(0, 0, 0, .5);
            color: red;
            width: 22px;
            height: 22px;
            line-height: 22px;
            border-radius: 50%;
            cursor: pointer;
        }

        .remove-btn:hover {
            background: rgba(0, 0, 0, .7);
        }

        /* Center layout when only one preview is present */
        .preview.preview-single {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .preview.preview-single .preview-item {
            width: 200px; /* constrain single item width */
            max-width: 70%;
        }
    </style>

    <script>
        // Existing create modal setup (kept for backward compatibility)
        (function () {
            const input = document.getElementById('fileInput');
            const preview = document.getElementById('preview');
            if (!input || !preview) return;
            let filesArray = [];

            input.addEventListener('change', () => {
                for (const file of input.files) filesArray.push(file);
                input.value = '';
                render();
            });

            preview.addEventListener('click', (e) => {
                const btn = e.target.closest ? e.target.closest('.remove-btn') : null;
                if (!btn) return;
                const index = Number(btn.getAttribute('data-index'));
                if (!Number.isNaN(index)) {
                    filesArray.splice(index, 1);
                    render();
                }
            });

            function render() {
                preview.innerHTML = '';
                preview.classList.toggle('preview-single', filesArray.length === 1);
                filesArray.forEach((file, index) => {
                    const item = document.createElement('div');
                    item.className = 'preview-item';
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = () => {
                            const img = document.createElement('img');
                            img.className = 'preview-img';
                            img.src = reader.result;
                            img.alt = file.name || 'preview image';
                            item.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    } else {
                        const box = document.createElement('div');
                        box.className = 'preview-file';
                        box.textContent = file.name;
                        item.appendChild(box);
                    }
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'remove-btn';
                    btn.setAttribute('data-index', String(index));
                    btn.innerHTML = '&times;';
                    item.appendChild(btn);
                    preview.appendChild(item);
                });
                const dt = new DataTransfer();
                filesArray.forEach(f => dt.items.add(f));
                input.files = dt.files;
            }
        })();

        // Reusable setup for edit modals (and any other file input + preview pair)
        function setupPreview(inputEl, previewEl) {
            if (!inputEl || !previewEl) return;
            let filesArray = [];
            inputEl.addEventListener('change', () => {
                filesArray = Array.from(inputEl.files);
                render();
            });
            previewEl.addEventListener('click', (e) => {
                const btn = e.target.closest ? e.target.closest('.remove-btn') : null;
                if (!btn) return;
                const index = Number(btn.getAttribute('data-index'));
                if (!Number.isNaN(index)) {
                    filesArray.splice(index, 1);
                    render();
                }
            });

            function render() {
                previewEl.innerHTML = '';
                previewEl.classList.toggle('preview-single', filesArray.length === 1);
                filesArray.forEach((file, index) => {
                    const item = document.createElement('div');
                    item.className = 'preview-item';
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = () => {
                            const img = document.createElement('img');
                            img.className = 'preview-img';
                            img.src = reader.result;
                            img.alt = file.name || 'preview image';
                            item.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    } else {
                        const box = document.createElement('div');
                        box.className = 'preview-file';
                        box.textContent = file.name;
                        item.appendChild(box);
                    }
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'remove-btn';
                    btn.setAttribute('data-index', String(index));
                    btn.innerHTML = '&times;';
                    item.appendChild(btn);
                    previewEl.appendChild(item);
                });
                const dt = new DataTransfer();
                filesArray.forEach(f => dt.items.add(f));
                inputEl.files = dt.files;
            }
        }

        // Initialize for all edit inputs (id starts with fileInputEdit_)
        document.querySelectorAll('input[id^="fileInputEdit_"]').forEach((inputEl) => {
            const container = inputEl.closest('label') ? inputEl.closest('label').parentElement : inputEl.parentElement;
            const previewEl = container ? container.querySelector('.preview') : null;
            setupPreview(inputEl, previewEl);
        });
    </script>

@endsection
