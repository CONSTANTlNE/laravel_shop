

<div style="height: 100%" class="offcanvas offcanvas-bottom rounded-m offcanvas-detached" id="menu-terms">
    <div class="content">
        <div class="d-flex pb-2">
            <div class="align-self-center">
                <h2 class="font-800 font-22 text-center">Terms & Conditions</h2>
            </div>
            <div class="align-self-center ms-auto">
                <a href="#"  data-bs-dismiss="offcanvas" class="icon icon-m">
                    <i class="bi bi-x-circle-fill color-red-dark font-18 me-n4"></i>
                </a>
            </div>
        </div>
        <div class="divider"></div>

        {!! $terms->text !!}

        <div class="d-flex justify-content-center">
            <button data-bs-dismiss="offcanvas"
                    class="gradient-highlight btn-full btn  shadow-bg shadow-bg-m pt-1 pb-2">
                Close
            </button>
        </div>
    </div>
</div>
