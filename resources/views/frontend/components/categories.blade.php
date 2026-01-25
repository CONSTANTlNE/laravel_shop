<div id="categories" data-menu-active="nav-homes"
     {{--         data-menu-load="menu-main.html"--}}
     style="width:280px;" class="offcanvas offcanvas-start offcanvas-detached rounded-m">

    <div class="card card-style  mb-3 rounded-m mt-3" data-card-height="150"
         style="background: url({{asset('shopz_man2.jpeg')}}) no-repeat center center; background-size: cover;"
    >
        <div class="card-top m-3">
            <a href="#" data-bs-dismiss="offcanvas" class="icon icon-xs bg-theme rounded-s color-theme float-end"><i
                    class="bi bi-caret-left-fill"></i></a>
        </div>
        <div class="card-bottom p-3">
            <h1 class="color-white font-20 font-700 mb-n2">shopz.ge</h1>
            <p class="color-white font-12 opacity-70 mb-n1">დაბალი ფასები,სწრაფი მიწოდება</p>
        </div>
        <div class="card-overlay bg-gradient-fade rounded-0"></div>
    </div>

    <div class="card card-style bg-23  rounded-m  list-group list-custom list-group-m mx-3 mb-4 mt-4">
        <a class="list-group-item"
           href="{{route('categories')}}">
            <i class="bi color-blue-dark bi-arrow-right-square-fill font-20"></i>
            <div>
                <strong class="product-name-title">{{__('All Categories')}}</strong>
            </div>
        </a>
        @foreach($categories as $catmenuindex => $category)
            @if(!$category->subcategories->isNotEmpty())
                <a class="list-group-item"
                   href="{{route('category.single',['category'=>$category->slug])}}">

                    <i class="bi color-blue-dark bi-arrow-right-square-fill font-20"></i>
                    <div><strong class="product-name-title">{{$category->name}}</strong>
                        {{--                    <span>List item Description</span>--}}
                    </div>
                </a>
            @else
                <a class="list-group-item"
                   href="#collapse-list-{{$catmenuindex}}"
                   aria-controls="collapse-list-{{$catmenuindex}}"
                   data-bs-toggle="collapse">
{{--                    <i class="bi color-red-dark bi-heart-fill"></i>--}}
                    <i class="bi color-blue-dark bi-arrow-right-square-fill font-20"></i>
                    <div>
                        <strong class="product-name-title">{{$category->name}}</strong>
                    </div>
                        <i class="bi bi-chevron-down"></i>
                </a>
                <div id="collapse-list-{{$catmenuindex}}" class="collapse " style="">
                    @foreach($category->subcategories as $subcatmenuindex => $subcategory)
                        <a href="{{route('category.single',['category'=>$subcategory->slug])}}" class="list-group-item">
                            <div class="ps-1">
                                <strong class="font-11 ">{{$subcategory->name}}</strong>
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
