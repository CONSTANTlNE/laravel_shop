<div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme" style="width:340px" id="menu-login">
    <form class="content" action="{{route('login')}}" method="post">
        @csrf
        <h5 class="mb-n1 font-12 color-highlight font-700 text-uppercase pt-1">Welcome</h5>
        <p class="font-24 font-800 mb-3">Login</p>
        <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
            <i class="bi bi-person-circle font-13"></i>
            <input type="text" name="email" class="form-control rounded-xs" id="c1" placeholder="Username" />
            <label for="c1"  class="color-theme">Username</label>
            <span>(required)</span>
        </div>
        <div class="form-custom form-label form-border form-icon mb-4 bg-transparent">
            <i class="bi bi-asterisk font-13"></i>
            <input type="password" name="password" class="form-control rounded-xs" id="c2" placeholder="Password" />
            <label for="c2" class="color-theme">Password</label>
            <span>(required)</span>
        </div>
        <button href="#" class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">SIGN IN</button>
        <div class="row">
            <div class="col-6 text-start">
                <a href="#" data-bs-toggle="offcanvas" data-bs-target="#menu-forgot" class="font-11 color-theme opacity-40 pt-3 d-block">Forgot Password?</a>
            </div>
            <div class="col-6 text-end">
                <a href="#" data-bs-toggle="offcanvas" data-bs-target="#menu-register" class="font-11 color-theme opacity-40 pt-3 d-block">Create Account</a>
            </div>
        </div>
    </form>
</div>
