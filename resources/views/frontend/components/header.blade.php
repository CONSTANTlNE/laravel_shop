<div class="header-bar header-fixed header-app header-bar-detached">
    <a data-bs-toggle="offcanvas" data-bs-target="#menu-main" href="#"><i class="bi bi-list color-theme"></i></a>
    <a href="#" class="header-title color-theme">Duo</a>
    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#menu-color"><i class="bi bi-palette-fill font-13 color-highlight"></i></a>
    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#menu-bell"><em class="badge bg-highlight ms-1">3</em><i class="font-14 bi bi-bell-fill"></i></a>
    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#search"><i class="bi bi-search"></i></a>

    @if(auth('admin')->check() || auth('web')->check())
        <form action="{{route('logout')}}" method="post">
            @csrf
            <button style="all: unset; cursor: pointer" type="submit" class="list-group-item">
                <i class="bi bi-box-arrow-in-right font-20"></i>
            </button>
        </form>
    @else
        <a href="#" data-bs-toggle="offcanvas" data-bs-target="#menu-login" class="list-group-item">
            <i class="bi bi-unlock-fill color-red-dark font-15"></i>

        </a>
    @endif
    <a href="#" class="show-on-theme-light" data-toggle-theme><i class="bi bi-moon-fill font-13"></i></a>
    <a href="#" class="show-on-theme-dark" data-toggle-theme ><i class="bi bi-lightbulb-fill color-yellow-dark font-13"></i></a>
</div>
