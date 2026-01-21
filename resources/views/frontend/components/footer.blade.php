<div id="footer-bar"  class="footer-bar footer-bar-detached">
    <a href="#">
        <i class="bi bi-card-list font-20" data-bs-toggle="offcanvas" data-bs-target="#menu-terms" rel="noreferrer noopener nofollow"></i>
        <span>{{__('Terms')}}</span></a>

        <a href="{{route('products.discounted')}}" @if(request()->routeIs('products.discounted')) class="active-nav" @endif>
{{--        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 14 14">--}}
{{--            <path fill="#264c99" fill-rule="evenodd"--}}
{{--                  d="M14 7A7 7 0 1 1 0 7a7 7 0 0 1 14 0m-3.812-3.188a.625.625 0 0 0-.884 0L3.812 9.304a.625.625 0 1 0 .884.884l5.492-5.492a.625.625 0 0 0 0-.884M4.803 3.63a1.174 1.174 0 1 0 0 2.349a1.174 1.174 0 0 0 0-2.349m4.394 4.393a1.174 1.174 0 1 0 0 2.349a1.174 1.174 0 0 0 0-2.349"--}}
{{--                  clip-rule="evenodd"/>--}}
{{--        </svg>--}}
            <i class="bi bi-percent font-17"></i>

            <span>{{__('Discounts')}}</span>
    </a>
    <a href="{{route('home')}}" @if(request()->routeIs('home')) class="active-nav" @endif >
        <i class="bi bi-house-fill font-16"></i>
        <span>{{__('Home')}}</span>
    </a>

    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#categories" rel="noreferrer noopener nofollow">
        <i
            class="bi bi-layout-text-sidebar font-17">
        </i><span>{{__('Categories')}}</span>
    </a>
    {{--    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#menu-main"><i class="bi bi-list"></i><span>Menu</span></a>--}}
    <a href="#"  onclick="openChatwoot()" id="chatwoot"  rel="noreferrer noopener nofollow"  >
        <i class="bi color-blue-dark bi-chat-fill font-25"></i>
        <span>{{__('Chat')}}</span>
    </a>

</div>

<script>
    function openChatwoot(){
        document.querySelector('.woot-widget-bubble').click();
    }
</script>
