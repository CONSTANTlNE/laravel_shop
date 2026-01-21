<div class="content m-2">
    @include('frontend.cart.items_component')
    @include('frontend.cart.finance_component')

    <div class="divider mb-4"></div>
    <div class="d-flex justify-content-center gap-4">
        <a href="#" class="btn btn-full bg-highlight btn-m text-uppercase font-800 rounded-sm"
           data-bs-dismiss="offcanvas">
            {{__('Close')}}
        </a>

        @if(auth('web')->check() || auth('admin')->check())
            <a href="{{route('checkout',['locale'=>app()->getLocale()])}}"
               class="btn btn-full bg-dark btn-m text-uppercase font-800 rounded-sm">
                {{__('Proceed to Checkout')}}
            </a>
        @else
            <a data-bs-toggle="offcanvas" data-bs-target="#menu-login"
               hx-post="{{route('login.htmx')}}"
               hx-vals='{"_token": "{{csrf_token()}}"}'
               hx-target="#menu-login"
{{--               onclick="document.getElementById('checkout').value=1"--}}
               class="btn btn-full bg-dark btn-m text-uppercase font-800 rounded-sm">
                {{__('Proceed to Checkout')}}
            </a>
        @endif
    </div>
</div>
