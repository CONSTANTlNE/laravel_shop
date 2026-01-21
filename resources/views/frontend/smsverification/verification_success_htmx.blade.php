{{--<div class="gradient-green px-3 py-3">--}}
{{--    <div class="d-flex mt-1 mb-3">--}}
{{--        <div class="align-self-center">--}}
{{--            <i class="bi bi-check-circle-fill font-22 pe-2 scale-box color-white"></i>--}}
{{--        </div>--}}
{{--        <div class="align-self-center">--}}
{{--            <h1 class="font-700 color-white mb-0">Successfully Verified</h1>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <p class="color-white opacity-90 pt-2">--}}
{{--        Your task was successfully completed! Great work! Tap the button to dismiss this box.--}}
{{--    </p>--}}
{{--    <a href="#" data-bs-dismiss="offcanvas" class="default-link btn btn-full btn-s bg-white color-black">Great</a>--}}
{{--</div>--}}
<form
    @if(env('DEV_PURCHASE_TEST'))
        action="{{route('purchase.test')}}"
    @else
        action="{{route('purchase')}}"
    @endif
    id="purchase_form" method="post" class="d-flex justify-content-center">
    @csrf
    <button onclick="spinner(this)" class="btn btn-full bg-highlight btn-m text-uppercase font-800 rounded-sm action-button">
        Purchase
    </button>
</form>

<script>

    function spinner(button){

            // Prevent multiple spinners
            if (!button.querySelector('.spinner-border')) {
                const spinner = document.createElement('span');
                spinner.className = 'spinner-border spinner-border-sm ms-2';
                spinner.role = 'status';
                spinner.innerHTML = '<span class="visually-hidden">Loading...</span>';
                button.appendChild(spinner);
            }

            // Delay disabling the button slightly to allow form submission
            setTimeout(() => {
                button.type = button;
            }, 10); // 10ms delay is enough
    }

</script>
