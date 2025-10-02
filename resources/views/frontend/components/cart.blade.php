{{--data-bs-toggle="offcanvas" data-bs-target="#menu-register"--}}

<style>
    /* Make the cart offcanvas clearly show a vertical scrollbar on all major browsers */
    #menu-register {
        /* Keep layout from shifting when scrollbar appears and ensure it’s reserved */
        scrollbar-gutter: stable both-edges;
        /* Firefox visible scrollbar styling */
        scrollbar-width: auto;
        scrollbar-color: rgba(0, 0, 0, 0.45) rgba(0, 0, 0, 0.08);
    }

    /* WebKit-based browsers (Chrome, Edge, Safari, Opera) */
    #menu-register::-webkit-scrollbar {
        width: 10px;
    }

    #menu-register::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.08);
        border-radius: 8px;
    }

    #menu-register::-webkit-scrollbar-thumb {
        background: rgba(0, 0, 0, 0.35);
        border-radius: 8px;
    }

    #menu-register:hover::-webkit-scrollbar-thumb {
        background: rgba(0, 0, 0, 0.55);
    }
</style>

<div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme w-100"
     style="max-width:800px; max-height: 90vh; overflow-y: auto; overflow-x: hidden;" id="menu-cart">
    <div class="content">
        <div class="card card-style m-0" id="cart_target">

        </div>
    </div>
</div>
