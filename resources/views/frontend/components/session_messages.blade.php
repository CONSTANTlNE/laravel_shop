@if($errors->any())
    <div class="d-flex justify-content-center">
        <div style="max-width: 500px"
             class="text-center alert bg-fade-red color-red-dark alert-dismissible rounded-s fade show"
             role="alert">
            @foreach($errors->all() as $error)
                <i class="bi bi-exclamation-triangle pe-2"></i>
                <strong>Warning</strong> - {{$error}}
                <button type="button" class="btn-close opacity-20 font-11 pt-3 mt-1" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                <br>
            @endforeach
        </div>
    </div>
@endif
@if(session()->has('success'))
    <div class="d-flex justify-content-center">
        <div style="max-width: 400px"
             class="alert bg-green-light shadow-bg shadow-bg-m alert-dismissible rounded-s fade show mb-3 text-center"
             role="alert">
            <i class="bi bi-check-circle-fill pe-2"></i>
            {{--                    <strong>Awesome</strong> - --}}
            {{session('success')}}
            <button type="button" class="btn-close opacity-10" data-bs-dismiss="alert"
                    aria-label="Close"></button>
        </div>
    </div>
@endif
@if(session()->has('status'))
    <div class="d-flex justify-content-center">
        <div style="max-width: 400px"
             class="alert bg-green-light shadow-bg shadow-bg-m alert-dismissible rounded-s fade show mb-3 text-center"
             role="alert">
            <i class="bi bi-check-circle-fill pe-2"></i>
            {{--                    <strong>Awesome</strong> - --}}
            {{session('status')}}
            <button type="button" class="btn-close opacity-10" data-bs-dismiss="alert"
                    aria-label="Close"></button>
        </div>
    </div>
@endif
