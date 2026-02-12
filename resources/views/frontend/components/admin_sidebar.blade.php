<div id="menu-admin" data-menu-active="nav-homes"
     {{--         data-menu-load="menu-main.html"--}}
     style="width:280px;" class="offcanvas offcanvas-start offcanvas-detached rounded-m">

    <div class="bg-theme mx-3 rounded-m shadow-m mt-3 mb-3">
        <div class="d-flex px-2 pb-2 pt-2">
            <div class="ps-2 align-self-center">
                <h5 class="ps-1 mb-0 line-height-xs pt-1">{{auth('admin')->name}}</h5>
{{--                <h6 class="ps-1 mb-0 font-400 opacity-40">Front End Designer</h6>--}}
            </div>
            <div class="ms-auto">
                <a href="#" data-bs-toggle="dropdown" class="icon icon-m ps-3">
                    <i class="bi bi-three-dots-vertical font-18 color-theme"></i>
                </a>
                <div class="dropdown-menu  bg-transparent border-0 mt-n1 ms-3">
                    <div class="card card-style rounded-m shadow-xl mt-1 me-1">
                        <div class="list-group list-custom list-group-s list-group-flush rounded-xs px-3 py-1">
                            <a href="page-profile-admin.html" class="color-theme opacity-70 list-group-item py-1">
                                <strong class="font-500 font-12">Your Profile</strong><i
                                    class="bi bi-chevron-right"></i>
                            </a>
                            <a href="page-activity.html" class="color-theme opacity-70 list-group-item py-1">
                                <strong class="font-500 font-12">Notifications</strong><i
                                    class="bi bi-chevron-right"></i>
                            </a>
                            <a href="page-login-2.html" class="color-theme opacity-70 list-group-item py-1">
                                <strong class="font-500 font-12">Log Out</strong><i class="bi bi-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <span class="menu-divider">{{__('Navigation')}}</span>
    <div class="menu-list">
        <div class="card card-style rounded-m p-3 py-2 mb-0" >

            <a href="#" class="d-flex">
                <i class="gradient-highlight shadow-bg shadow-bg-xs bi bi-gear-fill"></i>
                <div class="accordion border-0 accordion-s" id="accordion-group-users" style="width: 100%">
                    <div class="accordion-item">
                        <button class="accordion-button px-0 collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#accordion_users" aria-expanded="false">
                            <span class="font-600 font-13">{{__('Products')}}</span>
                            <i class=" bi bi-plus font-20" style="width: 15px"></i>
                        </button>
                        <div id="accordion_users" class="accordion-collapse collapse"
                             data-bs-parent="#accordion-group-users"
                             style="">
                            <ul>
                                <li onclick="window.location.href='{{ route('admin.products.all') }}'" >
                                     {{__('All Products')}}
                                </li>
                                <li onclick="window.location.href='{{ route('admin.products.sold') }}'">
                                    {{__('All Sales')}}
                                </li>
                                <li onclick="window.location.href='{{ route('admin.products.sold.sum') }}'">
                                    {{__('Summarized Sales')}}
                                </li>
                                <li onclick="window.location.href='{{ route('excel') }}'">
                                    {{__('Excel Import')}}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{route('admin.orders')}}" @if(request()->routeIs('admin.orders'))id="nav-homes"@endif>
                <i class="gradient-highlight shadow-bg shadow-bg-xs bi bi-house-fill">
                </i><span>{{__('Orders')}}</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="{{route('admin.carts')}}" @if(request()->routeIs('admin.carts'))id="nav-homes"@endif>
                <i class="gradient-highlight shadow-bg shadow-bg-xs bi bi-house-fill">
                </i><span>{{__('Cart Items')}}</span>
                <i class="bi bi-chevron-right"></i>
            </a>


            <a href="{{route('home')}}" >
                <i class="gradient-highlight shadow-bg shadow-bg-xs bi bi-house-fill">
                </i><span>{{__('Homepage')}}</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="{{route('admin.categories.all')}}"  @if(request()->routeIs('admin.categories.all'))id="nav-homes"@endif>
                <i class="gradient-highlight shadow-bg shadow-bg-xs bi bi-heart-fill">
                </i><span>{{__('All Categories')}}</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="{{route('discount.all')}}"  @if(request()->routeIs('discount.all'))id="nav-homes"@endif>
                <i class="gradient-highlight shadow-bg shadow-bg-xs bi bi-heart-fill">
                </i><span>{{__('Discounts')}}</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="{{route('coupons')}}" @if(request()->routeIs('coupons'))id="nav-homes"@endif>
                <i class="gradient-highlight shadow-bg shadow-bg-xs bi bi-heart-fill">
                </i><span>{{__('Coupons')}}</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="{{route('shippingprice')}}" @if(request()->routeIs('shippingprice'))id="nav-homes"@endif>
                <i class="gradient-highlight shadow-bg shadow-bg-xs bi bi-envelope-fill">
                </i><span>{{__('Shipping Prices')}}</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="{{route('admin.admins.all')}}" @if(request()->routeIs('admin.admins.all'))id="nav-homes"@endif>
                <i class="gradient-highlight shadow-bg shadow-bg-xs bi bi-envelope-fill">
                </i><span>{{__('Admins')}}</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="{{route('admin.users.all')}}"  @if(request()->routeIs('admin.users.all'))id="nav-homes"@endif>
                <i class="gradient-highlight shadow-bg shadow-bg-xs bi bi-envelope-fill">
                </i><span>{{__('Users')}}</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="{{route('admin.banners')}}"  @if(request()->routeIs('admin.banners'))id="nav-homes"@endif>
                <i class="gradient-highlight shadow-bg shadow-bg-xs bi bi-envelope-fill">
                </i><span>{{__('Banners')}}</span>
                <i class="bi bi-chevron-right"></i>
            </a>



            <a href="#" class="d-flex">
                <i class="gradient-highlight shadow-bg shadow-bg-xs bi bi-gear-fill"></i>
                <div class="accordion border-0 accordion-s" id="accordion-group-data" style="width: 100%">
                    <div class="accordion-item">
                        <button class="accordion-button px-0 collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#accordion_general_data" aria-expanded="false">
                            <span class="font-600 font-13">{{__('General Data')}}</span>
                            <i class="bi bi-plus font-20" style="width: 15px"></i>
                        </button>
                        <div id="accordion_general_data" class="accordion-collapse collapse"
                             data-bs-parent="#accordion-group-data"
                             style="">
                            <ul>
                                <li onclick="window.location.href='{{ route('site.data') }}'">
                                    Socials & Contacts
                                </li>
                                <li onclick="window.location.href='{{ route('admin.faqs') }}'">
                                    Q & A
                                </li>
                                <li onclick="window.location.href='{{ route('admin.terms') }}'">
                                    Terms And Conditions
                                </li>
                                <li onclick="window.location.href='{{ route('admin.products.all') }}'">
                                    About Us
                                    <i class="bi bi-chevron-right"></i>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{route('admin.translations')}}"  @if(request()->routeIs('admin.translations'))id="nav-homes"@endif>
                <i class="gradient-highlight shadow-bg shadow-bg-xs bi bi-envelope-fill">
                </i><span>{{__('Localization')}}</span>
                <i class="bi bi-chevron-right"></i>
            </a>

        </div>
    </div>

    <span class="menu-divider mt-4">{{__('Settings')}}</span>

    <div class="menu-list">
        <div class="card card-style rounded-m p-3 py-2 mb-0">
            <a href="#" data-bs-toggle="offcanvas" data-bs-target="#menu-color">
                <i class="gradient-highlight shadow-bg shadow-bg-xs bi bi-palette-fill"></i>
                <span>Highlights</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="#" data-toggle-theme data-trigger-switch="switch-1">
                <i class="gradient-dark shadow-bg shadow-bg-xs bi bi-moon-fill font-13"></i>
                <span>Dark Mode</span>
                <div class="form-switch ios-switch switch-green switch-s me-2">
                    <input type="checkbox" data-toggle-theme class="ios-input" id="switch-1">
                    <label class="custom-control-label" for="switch-1"></label>
                </div>
            </a>
        </div>
    </div>

    <p class="text-center mb-0 mt-n3 pb-3 font-9 text-uppercase font-600 color-theme">
        Made with
        <i class=" font-9 px-1 bi bi-heart-fill color-red-dark"></i>
        by Enabled in
        <span class="copyright-year"></span>.
    </p>

</div>
