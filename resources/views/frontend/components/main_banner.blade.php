    <div class="splide  slider-no-dots slider-no-arrows slider-boxed text-center mt-n2"
         id="banner-slider">
        <div class="splide__track">
            <div class="splide__list  w-100">
                @if(isset($banners) && $banners->isNotEmpty())
                    @foreach($banners as $banner)
                        <div class="splide__slide">
                            @if($banner->url!=null)
                                <a href="{{$banner->url}}" target="_blank"
                                   class="card card-style mx-0 shadow-card shadow-card-m bg-14"
                                   style="background-image: url({{$banner->getFirstMediaUrl('banner_image')}})"
                                   data-card-height="400"
                                >
                                    <div class="card-bottom pb-3 px-3">
                                        <h3 class="color-white mb-1">{{$banner->header}} </h3>
                                        <p class="color-white opacity-80 mb-0 mt-n1 font-14">{{$banner->description}}</p>
                                    </div>
                                    {{-- <div class="card-overlay bg-gradient-fade"></div> --}}
                                </a>
                            @else
                                <div class="card card-style mx-0 shadow-card shadow-card-m bg-14"
                                     style="background-image: url({{$banner->getFirstMediaUrl('banner_image')}})"
                                     data-card-height="400">
                                    <div class="card-bottom pb-3 px-3">
                                        <h3 class="color-white mb-1">{{$banner->header}} </h3>
                                        <p class="color-white opacity-80 mb-0 mt-n1 font-14">{{$banner->description}}</p>
                                    </div>
                                    {{--                                        <div class="card-overlay bg-gradient-fade"></div>--}}
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

