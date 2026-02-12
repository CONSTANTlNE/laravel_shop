<form class="content mb-0" style="max-width: 500px;min-width: 300px" method="post" action="{{route('customer.profile.update')}}">
    @csrf
    {{--            <h6 class="font-700 mb-n1 color-highlight">Account Settings</h6>--}}
    <h1 class="pb-2">{{__('Basic Information')}}</h1>

    {{--            <p>--}}
    {{--                Basic details about you. Set them here. These can be connected to your database and shown on the user profile.--}}
    {{--            </p>--}}

    <div class="divider"></div>

    <div class="form-custom form-label form-icon mb-3">
        <i class="bi bi-person-circle font-14"></i>
        <input type="text" class="form-control rounded-xs" id="name" name="name" value="{{auth('web')->user()->name}}">
        <label for="name" class="color-theme form-label-always-active font-10 opacity-50">{{__('Name.')}}</label>
    </div>

    <div class="form-custom form-label form-icon mb-3">
        <i class="bi bi-at font-16"></i>
        <input name="email" type="text" class="form-control rounded-xs" id="for" value="{{auth('web')->user()->email}}">
        <label for="email" class="color-theme form-label-always-active font-10 opacity-50">{{__('Email')}}</label>
    </div>
    <div class="form-custom form-label form-icon mb-3">
        <i class="bi bi-telephone-fill font-16"></i>
        <input name="mobile" type="text" class="form-control rounded-xs" id="phone" value="{{auth('web')->user()->mobile}} ">
        <label for="phone" class="color-theme form-label-always-active font-10 opacity-50">{{__('Mobile')}}</label>
    </div>
    <div class="form-custom form-label form-icon mb-3">
        <i class="bi bi-person-badge-fill font-16"></i>
        <input name="pid" type="text" class="form-control rounded-xs" id="pid" value="{{auth('web')->user()->pid}}">
        <label for="pid" class="color-theme form-label-always-active font-10 opacity-50">{{__('PID')}}</label>
    </div>
    <div class="form-custom form-label form-icon mb-3">
        <i class="bi bi-key font-16"></i>
        <input name="password" type="text" class="form-control rounded-xs" id="password" >
        <label for="password" class="color-theme form-label-always-active font-10 opacity-50">{{__('Password')}}</label>
    </div>
    <div class="form-custom form-label form-icon mb-3">
        <i class="bi bi-key font-16"></i>
        <input name="password_confirmation" type="text" class="form-control rounded-xs" id="password_confirmation">
        <label for="password_confirmation" class="color-theme form-label-always-active font-10 opacity-50">{{__('Repeat Password')}}</label>
    </div>

    <div class="d-flex justify-content-center mb-3 gap-2">
        <button
            data-bs-dismiss="offcanvas"
            type="button"
            class="default-link btn btn-m rounded-s gradient-highlight shadow-bg shadow-bg-s px-5 mb-0 mt-2">
            {{__('Close')}}
        </button>
        <button
            class="default-link btn btn-m rounded-s gradient-highlight shadow-bg shadow-bg-s px-5 mb-0 mt-2 action-button">
            {{__('Update')}}
        </button>
    </div>
</form>
