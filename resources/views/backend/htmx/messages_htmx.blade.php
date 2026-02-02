
    @if(isset($error))
    Swal.fire({
        icon: 'error',
        showConfirmButton: true,
        // timer: 2800,
        text: "{{$error}}",
    });
    @endif


    @if(isset($success))
    Swal.fire({
        icon: 'success',
        showConfirmButton: false,
        timer: 2800,
        text: "{{$success}}",
    });
    @endif
