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

<div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme w-100" style="max-width:800px; max-height: 90vh; overflow-y: auto; overflow-x: hidden;" id="menu-register">
    <div class="content">
        <div class="card card-style m-0">
            <div class="content m-2">
                <div class="d-flex mb-4">
                    <div class="me-3">
                        <h3 class="font-600">Your awesome long or short product title</h3>
                        <h5 class="pt-3">$99.<sup>99</sup></h5>
                        <button href="#" class="btn gradient-red shadow-bg shadow-bg-m text-start">
                            <i class="bi bi-trash  font-15"></i>
                        </button>
                    </div>
                    <div class="ms-auto">
                        <img src="{{asset('frontassets/images/test/1.webp')}}" class="rounded-m shadow-xl" width="130">
                    </div>
                </div>
                <div class="divider"></div>
                <div class="d-flex mb-3">
                    <div class="me-3">
                        <h3 class="font-600">iMac 27" 5k Display and Accessories</h3>
                        <h5 class="pt-3">$2499.<sup>99</sup></h5>
                        <button href="#" class="btn gradient-red shadow-bg shadow-bg-m text-start">
                            <i class="bi bi-trash font-15"></i>
                        </button>
                    </div>
                    <div class="ms-auto">
                        <img src="{{asset('frontassets/images/test/1.webp')}}" class="rounded-m shadow-xl" width="130">
                    </div>
                </div>
                <div class="divider"></div>
                <div class="d-flex mb-3">
                    <div class="me-3">
                        <h3 class="font-600">Macbook Pro 13" Core i7, 16GB, 512 SSD</h3>
                        <h5 class="pt-3">$1499.<sup>99</sup></h5>
                        <button href="#" class="btn gradient-red shadow-bg shadow-bg-m text-start">
                            <i class="bi bi-trash font-15"></i>
                        </button>
                    </div>
                    <div class="ms-auto">
                        <img src="{{asset('frontassets/images/test/1.webp')}}" class="rounded-m shadow-xl" width="130">
                    </div>
                </div>
                <div class="divider mb-3"></div>
                <div class="d-flex mb-3">
                    <div class="align-self-center w-100">
                        <div class="form-custom form-label form-icon mb-0">
                            <i class="bi bi-at font-16"></i>
                            <input type="email" class="form-control rounded-xs" id="c2" placeholder="name@example.com"
                                   pattern="[A-Za-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required="">
                            <label for="c2" class="color-theme">Your Email</label>
                            <div class="valid-feedback">Email address looks good!<!-- text for field valid--></div>
                            <div class="invalid-feedback">Email is missing or is invalid.</div>
                            <span>(required)</span>
                        </div>
                    </div>
                    <div class="align-self-center ms-auto">
                        <a href="#"
                           class="btn btn-full bg-blue-dark btn-m text-uppercase font-800 rounded-sm mb-0 ms-3">Apply</a>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="d-flex mb-2">
                    <div><h5 class="opacity-50 font-500">Products</h5></div>
                    <div class="ms-auto"><h5>$3500 </h5></div>
                </div>
                <div class="d-flex mb-2">
                    <div><h5 class="opacity-50 font-500">Shipping</h5></div>
                    <div class="ms-auto"><h5>$150 </h5></div>
                </div>
                <div class="d-flex mb-2">
                    <div><h5 class="opacity-50 font-500">Taxes</h5></div>
                    <div class="ms-auto"><h5>$50 </h5></div>
                </div>
                <div class="d-flex mb-2">
                    <div><h5 class="opacity-50 font-500">Promo Code</h5></div>
                    <div class="ms-auto"><h5>$700 </h5></div>
                </div>
                <div class="d-flex mb-3">
                    <div><h4 class="font-700">Grand Total</h4></div>
                    <div class="ms-auto"><h3>$3.000 </h3></div>
                </div>
                <div class="divider mb-4"></div>
                <a href="#" class="btn btn-full bg-highlight btn-m text-uppercase font-800 rounded-sm">
                    Proceed to Checkout
                </a>
            </div>
        </div>
    </div>
</div>
