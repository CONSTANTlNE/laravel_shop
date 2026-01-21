@if (count($errors))
    <div class="alert bg-fade-red color-red-dark alert-dismissible rounded-s fade show text-center" role="alert">
        @foreach($errors as $error)
            <i class="bi bi-exclamation-triangle pe-2"></i>  {{$error}}
        @endforeach
        <button type="button" class="btn-close opacity-20 font-11 pt-3 mt-1" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


<form class="content"
      hx-post="{{route('sms.verify.htmx')}}"
      hx-trigger="submit"
      hx-target="#menu-verification">
    @csrf
    <h5 class="font-24 font-800 mb-3 text-center">Enter Code</h5>
    <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
        <i class="bi bi-phone font-20"></i>
        <input name="code" type="text" class="form-control rounded-xs" id="code" placeholder="Code">
        <label for="code" class="color-theme">Code</label>
        <span>(required)</span>
    </div>
    <div class="d-flex justify-content-center gap-2">
        <button style="width: 100%" class="btn btn-full gradient-blue shadow-bg shadow-bg-s mt-4"
                hx-post="{{route('mobile.change.htmx')}}"
                hx-vals='{"_token": "{{csrf_token()}}"}'>
            Change Mobile
        </button>
        <button style="width: 100%" class="btn btn-full gradient-blue shadow-bg shadow-bg-s mt-4">
            Verify
        </button>
    </div>
</form>
