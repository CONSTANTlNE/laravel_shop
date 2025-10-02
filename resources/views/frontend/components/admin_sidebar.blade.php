<div id="menu-admin" data-menu-active="nav-homes"
     {{--         data-menu-load="menu-main.html"--}}
     style="width:280px;" class="offcanvas offcanvas-start offcanvas-detached rounded-m">

    <div class="card card-style bg-23 mb-3 rounded-m mt-3" data-card-height="150">
        <div class="card-top m-3">
            <a href="#" data-bs-dismiss="offcanvas" class="icon icon-xs bg-theme rounded-s color-theme float-end"><i class="bi bi-caret-left-fill"></i></a>
        </div>
        <div class="card-bottom p-3">
            <h1 class="color-white font-20 font-700 mb-n2">Admin</h1>
            <p class="color-white font-12 opacity-70 mb-n1">Bootstrap 5 Mobile PWA</p>
        </div>
        <div class="card-overlay bg-gradient-fade rounded-0"></div>
    </div>

    <div class="bg-theme mx-3 rounded-m shadow-m mt-3 mb-3">
        <div class="d-flex px-2 pb-2 pt-2">
            <div class="ps-2 align-self-center">
                <h5 class="ps-1 mb-0 line-height-xs pt-1">{{auth('admin')->name}}</h5>
                <h6 class="ps-1 mb-0 font-400 opacity-40">Front End Designer</h6>
            </div>

            <div class="ms-auto">
                <a href="#" data-bs-toggle="dropdown" class="icon icon-m ps-3">
                    <i class="bi bi-three-dots-vertical font-18 color-theme"></i>
                </a>
                <div class="dropdown-menu  bg-transparent border-0 mt-n1 ms-3">
                    <div class="card card-style rounded-m shadow-xl mt-1 me-1">
                        <div class="list-group list-custom list-group-s list-group-flush rounded-xs px-3 py-1">
                            <a href="page-profile-admin.html" class="color-theme opacity-70 list-group-item py-1">
                                <strong class="font-500 font-12">Your Profile</strong><i class="bi bi-chevron-right"></i>
                            </a>
                            <a href="page-activity.html" class="color-theme opacity-70 list-group-item py-1">
                                <strong class="font-500 font-12">Notifications</strong><i class="bi bi-chevron-right"></i>
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

    <span class="menu-divider">NAVIGATION</span>
    <div class="menu-list">
        <div class="card card-style rounded-m p-3 py-2 mb-0">
            <a href="{{route('home')}}" id="nav-homes">
                <i class="gradient-blue shadow-bg shadow-bg-xs bi bi-house-fill">
                </i><span>Homepage</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="{{route('admin.products.all')}}" id="nav-comps">
                <i class="gradient-blue shadow-bg shadow-bg-xs bi bi-gear-fill">
                </i><span>All Products</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="{{route('admin.categories.all')}}" id="nav-pages">
                <i class="gradient-blue shadow-bg shadow-bg-xs bi bi-heart-fill">
                </i><span>All Categories</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="{{route('discount.all')}}" id="nav-pages">
                <i class="gradient-blue shadow-bg shadow-bg-xs bi bi-heart-fill">
                </i><span>Discounts</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="{{route('admin.terms')}}" id="nav-media">
                <i class="gradient-blue shadow-bg shadow-bg-xs bi bi-image-fill">
                </i><span>Terms</span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <a href="{{route('admin.faqs')}}" id="nav-mails">
                <i class="gradient-blue shadow-bg shadow-bg-xs bi bi-envelope-fill">
                </i><span>Q & A</span>
                <i class="bi bi-chevron-right"></i>
            </a>
        </div>
    </div>

    <span class="menu-divider mt-4">SETTINGS</span>
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



    <p class="text-center mb-0 mt-n3 pb-3 font-9 text-uppercase font-600 color-theme">Made with <i class=" font-9 px-1 bi bi-heart-fill color-red-dark"></i> by Enabled in <span class="copyright-year"></span>.</p>

</div>
