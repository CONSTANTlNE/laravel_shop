@if (count($errors))
    <div class="alert bg-fade-red color-red-dark alert-dismissible rounded-s fade show text-center" role="alert">
        @foreach($errors as $error)
            <i class="bi bi-exclamation-triangle pe-2"></i>  {{$error}}
        @endforeach
        <button type="button" class="btn-close opacity-20 font-11 pt-3 mt-1" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form class="content"
      hx-post="{{route('store.mobile.htmx')}}"
      hx-trigger="submit"
      hx-target="#menu-verification">
    @csrf
    <h5 class="font-24 font-800 mb-3 text-center">SMS Verification</h5>
    <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
        <i class="bi bi-phone font-20"></i>
        <input type="text" name="mobile" class="form-control rounded-xs" id="mobile_number" placeholder="551507697">
        <label for="mobile_number" class="color-theme">Mobile</label>
        <span>(required)</span>
    </div>
    <button style="width: 100%" class="btn btn-full gradient-blue shadow-bg shadow-bg-s mt-4 action-button">Send
    </button>

</form>

