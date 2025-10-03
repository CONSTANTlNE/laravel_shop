<!-- Register-->
<div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme" style="width:340px; scrollbar-width: none;"
     id="menu-register">
    <div class="content">
        <h5 class="mb-n1 font-12 color-highlight font-700 text-uppercase pt-1">Welcome</h5>
        <h1 class="font-24 font-800 mb-3">Register</h1>
        <form action="{{route('register')}}" method="post">
            @csrf
            <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
                <i class="bi bi-person-circle font-13"></i>
                <input type="text" name="name" class="form-control rounded-xs" id="c1name" value="{{old('name')}}" placeholder="Username"/>
                <label for="c1name" class="color-theme">Username</label>
                <span>(required)</span>
            </div>
            <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
                <i class="bi bi-at font-17"></i>
                <input type="text" name="email" class="form-control rounded-xs" id="c1"  value="{{old('email')}}" placeholder="Email"/>
                <label for="c1" class="color-theme">Email</label>
                <span>(required)</span>
            </div>
            <div class="form-custom form-label form-border form-icon mb-4 bg-transparent">
                <i class="bi bi-asterisk font-13"></i>
                <input type="password" name="password" class="form-control rounded-xs" id="c2email" placeholder="Password"/>
                <label for="c2email" class="color-theme">Password</label>
                <span>(required)</span>
                @error('password')
                {{$message}}
                @enderror
            </div>
            <div class="form-custom form-label form-border form-icon mb-4 bg-transparent">
                <i class="bi bi-asterisk font-13"></i>
                <input type="password" name="password_confirmation" class="form-control rounded-xs" id="registration"
                       placeholder="Repeat Password"/>
                <label for="registration" class="color-theme">Password</label>
                <span>(required)</span>
            </div>
            <button class="btn btn-full gradient-blue shadow-bg shadow-bg-s mt-4 w-100">REGISTER</button>
        </form>
        <div class="divider"></div>
        <a href="#" class="btn-full btn border-blue-dark color-blue-dark">
            <svg viewBox="0 0 256 262" preserveAspectRatio="xMidYMid" width="25" height="25">
                <path
                    d="M255.878 133.451c0-10.734-.871-18.567-2.756-26.69H130.55v48.448h71.947c-1.45 12.04-9.283 30.172-26.69 42.356l-.244 1.622 38.755 30.023 2.685.268c24.659-22.774 38.875-56.282 38.875-96.027"
                    fill="#4285F4"/>
                <path
                    d="M130.55 261.1c35.248 0 64.839-11.605 86.453-31.622l-41.196-31.913c-11.024 7.688-25.82 13.055-45.257 13.055-34.523 0-63.824-22.773-74.269-54.25l-1.531.13-40.298 31.187-.527 1.465C35.393 231.798 79.49 261.1 130.55 261.1"
                    fill="#34A853"/>
                <path
                    d="M56.281 156.37c-2.756-8.123-4.351-16.827-4.351-25.82 0-8.994 1.595-17.697 4.206-25.82l-.073-1.73L15.26 71.312l-1.335.635C5.077 89.644 0 109.517 0 130.55s5.077 40.905 13.925 58.602l42.356-32.782"
                    fill="#FBBC05"/>
                <path
                    d="M130.55 50.479c24.514 0 41.05 10.589 50.479 19.438l36.844-35.974C195.245 12.91 165.798 0 130.55 0 79.49 0 35.393 29.301 13.925 71.947l42.211 32.783c10.59-31.477 39.891-54.251 74.414-54.251"
                    fill="#EB4335"/>
            </svg>
            ავტორიზაცია
        </a>
        <div class="row">
            <div class="col-6 text-start">
                <a href="#" data-bs-toggle="offcanvas" data-bs-target="#menu-forgot"
                   class="font-11 color-theme opacity-40 pt-3 d-block">Forgot Password?</a>
            </div>
            <div class="col-6 text-end">
                <a href="#" data-bs-toggle="offcanvas" data-bs-target="#menu-login"
                   class="font-11 color-theme opacity-40 pt-3 d-block">Login Account</a>
            </div>
        </div>
    </div>
</div>
