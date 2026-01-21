<div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
     style="width: 340px; visibility: visible;" id="menu-forgot" aria-modal="true" role="dialog">
    <div class="content">
        {{--        <h5 class="mb-n1 font-12 color-highlight font-700 text-uppercase pt-1">Welcome</h5>--}}
        <h1 class="font-24 font-800 mb-3">{{__('Recover Password')}}</h1>
        <form action="{{route('password.email')}}" method="post">
            @csrf
            <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
                <i class="bi bi-at font-14"></i>
                <input type="text" name="email" class="form-control rounded-xs" id="c1forgot"
                       placeholder="{{__('Email')}}">
                <label for="c1forgot" class="color-theme">{{__('Email')}}</label>
                <span>({{__('required')}})</span>
            </div>
            <button style="width: 100%" class="btn btn-full w-full gradient-red shadow-bg shadow-bg-s mt-4">{{__('Recover')}}</button>
        </form>
        <div class="row">
            <div class="col-6 text-start">
                <a href="#" data-bs-toggle="offcanvas" data-bs-target="#menu-login"
                   class="font-11 color-theme opacity-40 pt-3 d-block" onclick="spinner(this)">
                    {{__('Login')}}
                </a>
            </div>
            <div class="col-6 text-end">
                <a href="#"
                   data-bs-toggle="offcanvas"
                   data-bs-target="#menu-register"
                   hx-post="{{route('register.htmx')}}"
                   hx-target="#menu-register"
                   hx-vals='{"_token": "{{csrf_token()}}"}'
                   class="font-11 color-theme opacity-40 pt-3 d-block">{{__('Register')}}</a>
            </div>
        </div>
    </div>
</div>
