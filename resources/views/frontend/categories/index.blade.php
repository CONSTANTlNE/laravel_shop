@extends('frontend.components.layout')

@section('front-categories')
    <div class="card card-style mx-0">
        <div class="content">
            <h2 class="text-center mb-3">Category</h2>
            <div class="d-flex justify-content-center gap-3 mb-3">
                <form action="">
                    <button style="all: unset;cursor:pointer" class="d-flex">
                        <i class="bi bi-arrow-down color-blue-dark font-20"></i>
                        <i class="bi bi-arrow-up font-20"></i>
                    </button>
                </form>
                <form class="d-flex gap-2">
                    <input type="text" class="form-control rounded-xs"
                           placeholder="Min Price"
                           pattern="[A-Za-z ]{1,32}"
                           required="">
                    <input type="text" class="form-control rounded-xs"
                           placeholder="Max Price"
                           pattern="[A-Za-z ]{1,32}"
                           required="">
                    <button style="all: unset;cursor:pointer">
                        <i class="bi bi-funnel-fill font-20"></i>
                    </button>
                </form>
            </div>
            <div class="row mb-0 justify-content-center">
                <div class="col-6 col-lg-2">
                    <div class="card card-style custom-card m-0 bg-21" data-card-height="140" style="height: 140px;">

                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip
                        M9X</h5>
                    <span class="color-green-dark d-block font-11 font-600">In Stock</span>
                    <h2 class="mt-n1">$2499.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="card card-style custom-card m-0 bg-21" data-card-height="140" style="height: 140px;">

                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip
                        M9X</h5>
                    <span class="color-green-dark d-block font-11 font-600">In Stock</span>
                    <h2 class="mt-n1">$2499.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="card card-style custom-card m-0 bg-30" data-card-height="140" style="height: 140px;">
                        <div class="card-top p-2">
                            <span class="bg-green-dark p-2 py-1 rounded-sm font-13 font-600">-50%</span>
                        </div>
                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Apple Watch, Ceramic Edition, White Leather
                        Band</h5>
                    <span class="color-blue-dark d-block font-11 font-600">Featured this Week</span>
                    <h2 class="pb-3 mt-n1">$2999.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="card card-style custom-card m-0 bg-28" data-card-height="140" style="height: 140px;">
                        <div class="card-top p-2">
                            <span class="bg-red-dark p-2 py-1 rounded-sm font-13 font-600">-50%</span>
                        </div>

                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Air, 256GB SSD, 16GB DDR4, Apple Chip
                        M5X</h5>
                    <span class="color-red-dark d-block font-11 font-600">Out of Stock</span>
                    <h2 class="pb-3 mt-n1">$1999.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="card card-style custom-card m-0 bg-21" data-card-height="140" style="height: 140px;">

                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip
                        M9X</h5>
                    <span class="color-green-dark d-block font-11 font-600">In Stock</span>
                    <h2 class="mt-n1">$2499.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="card card-style custom-card m-0 bg-21" data-card-height="140" style="height: 140px;">

                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip
                        M9X</h5>
                    <span class="color-green-dark d-block font-11 font-600">In Stock</span>
                    <h2 class="mt-n1">$2499.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="card card-style custom-card m-0 bg-21" data-card-height="140" style="height: 140px;">

                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip
                        M9X</h5>
                    <span class="color-green-dark d-block font-11 font-600">In Stock</span>
                    <h2 class="mt-n1">$2499.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="card card-style custom-card m-0 bg-21" data-card-height="140" style="height: 140px;">

                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip
                        M9X</h5>
                    <span class="color-green-dark d-block font-11 font-600">In Stock</span>
                    <h2 class="mt-n1">$2499.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="card card-style custom-card m-0 bg-30" data-card-height="140" style="height: 140px;">
                        <div class="card-top p-2">
                            <span class="bg-green-dark p-2 py-1 rounded-sm font-13 font-600">-50%</span>
                        </div>
                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Apple Watch, Ceramic Edition, White Leather
                        Band</h5>
                    <span class="color-blue-dark d-block font-11 font-600">Featured this Week</span>
                    <h2 class="pb-3 mt-n1">$2999.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="card card-style custom-card m-0 bg-28" data-card-height="140" style="height: 140px;">
                        <div class="card-top p-2">
                            <span class="bg-red-dark p-2 py-1 rounded-sm font-13 font-600">-50%</span>
                        </div>

                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Air, 256GB SSD, 16GB DDR4, Apple Chip
                        M5X</h5>
                    <span class="color-red-dark d-block font-11 font-600">Out of Stock</span>
                    <h2 class="pb-3 mt-n1">$1999.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="card card-style custom-card m-0 bg-21" data-card-height="140" style="height: 140px;">

                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip
                        M9X</h5>
                    <span class="color-green-dark d-block font-11 font-600">In Stock</span>
                    <h2 class="mt-n1">$2499.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="card card-style custom-card m-0 bg-21" data-card-height="140" style="height: 140px;">

                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip
                        M9X</h5>
                    <span class="color-green-dark d-block font-11 font-600">In Stock</span>
                    <h2 class="mt-n1">$2499.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="card card-style custom-card m-0 bg-21" data-card-height="140" style="height: 140px;">

                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip
                        M9X</h5>
                    <span class="color-green-dark d-block font-11 font-600">In Stock</span>
                    <h2 class="mt-n1">$2499.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="card card-style custom-card m-0 bg-21" data-card-height="140" style="height: 140px;">

                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip
                        M9X</h5>
                    <span class="color-green-dark d-block font-11 font-600">In Stock</span>
                    <h2 class="mt-n1">$2499.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="card card-style custom-card m-0 bg-30" data-card-height="140" style="height: 140px;">
                        <div class="card-top p-2">
                            <span class="bg-green-dark p-2 py-1 rounded-sm font-13 font-600">-50%</span>
                        </div>
                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Apple Watch, Ceramic Edition, White Leather
                        Band</h5>
                    <span class="color-blue-dark d-block font-11 font-600">Featured this Week</span>
                    <h2 class="pb-3 mt-n1">$2999.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="card card-style custom-card m-0 bg-28" data-card-height="140" style="height: 140px;">
                        <div class="card-top p-2">
                            <span class="bg-red-dark p-2 py-1 rounded-sm font-13 font-600">-50%</span>
                        </div>

                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Air, 256GB SSD, 16GB DDR4, Apple Chip
                        M5X</h5>
                    <span class="color-red-dark d-block font-11 font-600">Out of Stock</span>
                    <h2 class="pb-3 mt-n1">$1999.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="card card-style custom-card m-0 bg-21" data-card-height="140" style="height: 140px;">

                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip
                        M9X</h5>
                    <span class="color-green-dark d-block font-11 font-600">In Stock</span>
                    <h2 class="mt-n1">$2499.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="card card-style custom-card m-0 bg-21" data-card-height="140" style="height: 140px;">

                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip
                        M9X</h5>
                    <span class="color-green-dark d-block font-11 font-600">In Stock</span>
                    <h2 class="mt-n1">$2499.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="card card-style custom-card m-0 bg-21" data-card-height="140" style="height: 140px;">

                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip
                        M9X</h5>
                    <span class="color-green-dark d-block font-11 font-600">In Stock</span>
                    <h2 class="mt-n1">$2499.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="card card-style custom-card m-0 bg-21" data-card-height="140" style="height: 140px;">

                    </div>
                    <h5 class="font-600 font-16 line-height-sm pt-3">Macbook Pro, 2TB SSD, 64GB DDR4, Apple Chip
                        M9X</h5>
                    <span class="color-green-dark d-block font-11 font-600">In Stock</span>
                    <h2 class="mt-n1">$2499.<sup class="font-14 font-400 opacity-50">99</sup></h2>
                </div>
                <div class="d-flex justify-content-center mt-5">
                    <nav aria-label="pagination-demo">
                        <ul class="pagination px-3">
                            <li class="page-item">
                                <a class="page-link rounded-xs color-white bg-dark-dark shadow-xl border-0" href="#"
                                   tabindex="-1" aria-disabled="true"><i class="bi bi bi-chevron-left"></i></a>
                            </li>
                            <li class="page-item"><a class="page-link rounded-xs bg-dark-dark shadow-l border-0"
                                                     href="#">1</a></li>
                            <li class="page-item"><a
                                    class="page-link rounded-xs bg-dark-dark bg-transparent shadow-l border-0" href="#">2</a>
                            </li>
                            <li class="page-item"><a class="page-link rounded-xs  bg-highlight  shadow-l border-0"
                                                     href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link rounded-xs color-white bg-dark-dark shadow-l border-0" href="#"><i
                                        class="bi bi bi-chevron-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
