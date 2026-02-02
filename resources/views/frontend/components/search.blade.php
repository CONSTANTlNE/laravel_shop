<div id="search"
     {{-- data-menu-load="menu-bell.html" --}}
     style="height:max-content;" class="offcanvas offcanvas-top offcanvas-detached rounded-m">
    <div class="content">
        <div class="form-custom form-label form-icon mb-3">
            <i class="bi bi-search"></i>
            <input type="text"
                   hx-trigger="input delay:500ms"
                   hx-target="#search_target"
                   hx-post="{{route('product.search.htmx')}}"
                   hx-vals='{"_token": "{{csrf_token()}}"}'
                   hx-indicator="#search_indicator"
                   name="search"
                   class="form-control rounded-xs">
            <label for="c1search" class="color-theme">{{__('Search')}}</label>
        </div>
        <div class="divider mt-2 mb-3"></div>
        <div class="d-flex justify-content-center">
            <div id="search_indicator" class="htmx-indicator"></div>
        </div>
        <div class="card card-style mx-0" id="search_target">

        </div>
        <div class="mb-3"></div>

        <div class="d-flex justify-content-center gap-2">
            <a data-bs-dismiss="offcanvas" class="btn btn-full btn-m gradient-highlight shadow-bg shadow-bg-s mt-3">
                {{__('Cancel')}}
            </a>
            <a href="page-activity.html" class="btn btn-full btn-m gradient-highlight shadow-bg shadow-bg-s mt-3">
                {{__('View All')}}
            </a>
        </div>
    </div>
</div>
