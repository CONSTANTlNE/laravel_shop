@extends('frontend.components.layout')

@section('index-meta')
    <title>shopz.ge</title>
    <link rel="canonical" href="https://shopz.ge">
    <meta name="description" content="ონლაინ მაღაზია, დაბალი ფასები და სწრაფი მიწოდება">
    <meta name="keywords" content="ციფრული მენიუ, QR მენიუ, რესტორნის მენიუ, შეფასების სისტემა, QR menu">
    <meta property="og:title" content="shopz.ge">
    <meta property="og:description" content="ონლაინ მაღაზია, დაბალი ფასები და სწრაფი მიწოდება">
    <meta property="og:image" content="{{asset('shopz_man2.jpeg')}}">
    <meta property="og:url" content="https://www.shopz.ge/">
@endsection


@section('index')

    {{--  featured  --}}
    @include('frontend.components.featured_products')

    <div class="divider mx-3 mt-5 mb-4"></div>
    {{--  show categories + products if definad as main  --}}
    <div>

        @foreach($formain as $mainindex => $main)
            <div class="card card-style mx-0">
                <div class="content">
                    <div class="d-flex justify-content-center align-items-center gap-2">
                        <h2 class="text-center mb-3">
                            {{$main->category->first()?->name}}
                            {{$main->subcategory->first()?->name}}
                        </h2>
                        {{-- change order --}}
                        @auth('admin')
                            <form method="post" action="{{route('home.order.change')}}"
                                  class="d-flex justify-content-center gap-3 mb-3">
                                @csrf
                                <input type="hidden" name="record_id" value="{{$main->id}}">
                                <label class="form-check-label">
                                    {{__('Order')}}
                                </label>
                                <select name="order" id=""
                                        onchange="this.form.submit()"
                                        style="width: 70px;"
                                        class="form-select rounded-xs px-1">
                                    @foreach($formain as $index =>$ggg)
                                        <option
                                            @selected($ggg->order==$main->order)
                                            value="{{$ggg->order}}">
                                            {{$ggg->order}}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        @endauth
                    </div>
                    <div class="row mb-0 justify-content-center">
                        @if(!$main->subcategory->isEmpty() )
                            @if($main->subcategory->first()?->is_slider==true)
                                <div class="splide category-slider slider-dots-under slider-boxed"
                                     id="category-slider-{{$mainindex}}">
                                    <div class="splide__track">
                                        <div class="splide__list">
                                            @endif
                                            @foreach($main->subcategory->first()->products as $product)
                                                @php
                                                    $mainImage = $product->media->where('main',1)->first();
                                                   if (!$mainImage){
                                                      $just_image=$product->media->first();
                                                   } else {
                                                      $just_image=null;
                                                   }
                                                @endphp
                                                @if($main->subcategory->first()?->is_slider==true)
                                                    <div class="splide__slide">
                                                        @include('frontend.components.single_product_component')
                                                    </div>
                                                @else
                                                    <div
                                                        class="col-6 col-sm-6 col-md-4 col-lg-3 text-center mb-3 d-flex flex-column justify-content-between ps-1 pe-1">
                                                        @include('frontend.components.single_product_component')
                                                    </div>
                                                @endif
                                            @endforeach
                                            @if($main->subcategory->first()?->is_slider==true)
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            @if($main->category->isNotEmpty())
                                @if($main->category->first()?->is_slider==true)
                                    <div class="splide category-slider slider-dots-under slider-boxed"
                                         id="category-slider-{{$mainindex}}">
                                        <div class="splide__track">
                                            <div class="splide__list">
                                                @endif
                                                @foreach( $main->category->first()?->products as $product)
                                                    @php
                                                        $mainImage = $product->media->where('main',1)->first();

                                                        if (!$mainImage){
                                                          $just_image=$product->media->first();
                                                        } else {
                                                            $just_image=null;
                                                        }
                                                    @endphp
                                                    @if($main->category->first()?->is_slider==true)
                                                        <div class="splide__slide">
                                                            @include('frontend.components.single_product_component')
                                                        </div>
                                                    @else
                                                        <div
                                                            class="col-6 col-sm-6 col-md-4 col-lg-3 text-center mb-3 d-flex flex-column justify-content-between ps-1 pe-1">
                                                            @include('frontend.components.single_product_component')
                                                        </div>
                                                    @endif
                                                @endforeach
                                                @if($main->category->first()?->is_slider==true)
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endif
                    </div>
                    <div class="d-flex justify-content-center mt-2">
                        <a href="{{route('category.single',['category' => $main->category->first()?->slug ? $main->category->first()?->slug : $main->subcategory->first()?->slug])}}"
                           style="min-width: 300px"
                           class="btn-full btn gradient-highlight shadow-bg shadow-bg-m ">
                            {{__('View All')}}
                        </a>
                    </div>
                </div>
            </div>
    @endforeach

@endsection
