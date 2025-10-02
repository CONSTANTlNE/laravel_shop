<div id="categories" data-menu-active="nav-homes"
     {{--         data-menu-load="menu-main.html"--}}
     style="width:280px;" class="offcanvas offcanvas-start offcanvas-detached rounded-m">

    <div class="card card-style bg-23 mb-3 rounded-m mt-3" data-card-height="150">
        <div class="card-top m-3">
            <a href="#" data-bs-dismiss="offcanvas" class="icon icon-xs bg-theme rounded-s color-theme float-end"><i
                    class="bi bi-caret-left-fill"></i></a>
        </div>
        <div class="card-bottom p-3">
            <h1 class="color-white font-20 font-700 mb-n2">Duo Mobile</h1>
            <p class="color-white font-12 opacity-70 mb-n1">Bootstrap 5 Mobile PWA</p>
        </div>
        <div class="card-overlay bg-gradient-fade rounded-0"></div>
    </div>

    <div class="card card-style bg-23  rounded-m mt-3 list-group list-custom list-group-m mx-3 mb-4">
        <a class="list-group-item"
           href="{{route('categories')}}">
            <i class="bi color-red-dark bi-heart-fill"></i>
            <div>
                <strong>All Categories</strong>
            </div>
        </a>
        @foreach($categories as $catmenuindex => $category)
            <a class="list-group-item" data-bs-toggle="collapse"
               href="#collapse-list-{{$catmenuindex}}" aria-controls="collapse-list-1"
               aria-expanded="true">
                <i class="bi color-red-dark bi-heart-fill"></i>
                <div><strong>{{$category->name}}</strong>
                    <span>List item Description</span>
                </div>
                @if($category->subcategories->isNotEmpty())
                    <i class="bi bi-chevron-down"></i>
                @endif
            </a>
            @if($category->subcategories->isNotEmpty())
                <div id="collapse-list-{{$catmenuindex}}" class="collapse " style="">
                    @foreach($category->subcategories as $subcatmenuindex => $subcategory)
                        <a href="{{route('category.single',['category'=>$subcategory->slug])}}" class="list-group-item">
                            <div class="ps-1">
                                <strong class="font-12">{{$subcategory->name}}</strong>
                            </div>
                            <i class="bi bi-chevron-right font-9 color-gray-dark ps-4"></i>
                        </a>
                    @endforeach
                </div>
            @endif
        @endforeach
    </div>


    <p class="text-center mb-0 mt-n3 pb-3 font-9 text-uppercase font-600 color-theme">Made with <i
            class=" font-9 px-1 bi bi-heart-fill color-red-dark"></i> by Enabled in <span class="copyright-year"></span>.
    </p>
</div>
