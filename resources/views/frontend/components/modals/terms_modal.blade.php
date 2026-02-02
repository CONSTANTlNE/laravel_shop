
<div style="height: 96%" class="offcanvas offcanvas-bottom rounded-m offcanvas-detached d-flex flex-column" id="menu-terms">
    <div style="height: 96%" class="content d-flex flex-column  mb-0">
        <div class="d-flex justify-content-center pb-2">
            <div class="align-self-center">
                <h2 class="font-800 font-22 text-center">{{__('Terms & Conditions')}}</h2>
            </div>
        </div>
        <div class="divider mb-3"></div>

        <div class="flex-grow-1 overflow-auto mb-3">
            {!! $terms?->text !!}
        </div>

        <div class="d-flex justify-content-center mt-auto mb-2">
            <button data-bs-dismiss="offcanvas"
                    class="gradient-highlight btn-full btn shadow-bg shadow-bg-m pt-1 pb-2">
                {{__('Close')}}
            </button>
        </div>
    </div>
</div>
