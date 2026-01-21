<div class="header-bar header-fixed header-app header-bar-detached">

    <a data-bs-toggle="offcanvas" data-bs-target="#menu-main" href="#"><i
            class="bi bi-list color-theme font-20"></i></a>
    @auth('admin')
        <a data-bs-toggle="offcanvas" data-bs-target="#menu-admin" href="#">
            <i class="bi bi-gear"></i>
            ADMIN
        </a>
    @endauth
    <a href="#" class="header-title color-theme"></a>
    {{--    color menu modal--}}
    {{--    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#menu-color">--}}
    {{--        <i  class="bi bi-palette-fill font-13 color-highlight"></i>--}}
    {{--    </a>--}}
    {{--    --}}

    {{--    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#menu-bell">--}}
    {{--        <em class="badge bg-highlight ms-1" style="top:6px;right:5px">3</em>--}}
    {{--        <i class="font-14 bi bi-bell-fill font-20"></i>--}}
    {{--    </a>--}}

    {{--    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#menu-cart">--}}
    {{--        <i class="bi bi-cart4 font-20"></i>--}}
    {{--        <span>Cart</span>--}}
    {{--        <em class="badge bg-highlight ms-1 font-10">3</em>--}}
    {{--    </a>--}}

    <a href="#" data-bs-toggle="offcanvas"
       hx-post="{{route('cart.get.items')}}"
       hx-target="#cart_target"
       @if(request()->routeIs('checkout')) style="display:none" @endif
       hx-vals='{"_token":"{{csrf_token()}}","cart_token":"{{request()->cookie('cart_token')}}"}'
       data-bs-target="#menu-cart">
        <em id="cart_icon_number" style="top:6px;right:5px"
            class="badge bg-highlight ms-1 font-10">
            {{ $carttotal ?? 0 }}
        </em>
        <i class="bi bi-cart4 font-20"></i>
    </a>
    @if(!request()->routeIs('checkout'))
        <a href="#" data-bs-toggle="offcanvas" data-bs-target="#search"><i class="bi bi-search font-20"></i></a>
    @endif


    @if(auth('admin')->check() || auth('web')->check())
        <form action="{{route('logout')}}" method="post">
            @csrf
            <button style="all: unset; cursor: pointer;width: 40px" type="submit" class="bi ">
                <i class="bi bi-box-arrow-in-right color-red-dark font-25"></i>
            </button>
        </form>
    @else
        <button style="all:unset;cursor: pointer;width: 30px; margin-right: 10px;"
                data-bs-toggle="offcanvas"
                hx-post="{{route('login.htmx')}}"
                hx-vals='{"_token": "{{csrf_token()}}"}'
                hx-target="#menu-login"
                data-bs-target="#menu-login" class="bi ">
            {{--            <i class="bi bi-unlock-fill color-red-dark font-15"></i>--}}
            <i class="bi bi-box-arrow-in-right  color-green-dark font-25"></i>
        </button>
    @endif
    {{--    <a href="#" class="show-on-theme-light" data-toggle-theme><i class="bi bi-moon-fill font-13"></i></a>--}}
    {{--    <a href="#" class="show-on-theme-dark" data-toggle-theme><i--}}
    {{--            class="bi bi-lightbulb-fill color-yellow-dark font-13"></i></a>--}}
</div>
