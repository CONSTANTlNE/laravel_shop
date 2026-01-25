
<div class="d-flex justify-content-start">
    <button style="all:unset;cursor:pointer"
            class="mb-2"
            data-bs-toggle="offcanvas"
            data-bs-target="#edit_description">
        <i class="bi bi-pencil-square color-blue-dark font-18"></i>
        Edit Description
    </button>

    <div style="height: 100%" class="offcanvas offcanvas-bottom rounded-m offcanvas-detached" id="edit_description">
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

            <div class="card card-style h-100">
                <div class="content mx-0 ms-0">
                    <div class="tabs tabs-pill" id="tab-group-2">
                        <div class="tab-controls rounded-m p-1">
                            @foreach($locales as $locale)
                                <a class="font-12 rounded-m" data-bs-toggle="collapse" href="#tab-{{$locale->abbr}}"
                                   aria-expanded="{{$locale->main==1 ? 'true' : 'false'}}">{{$locale->language}}
                                </a>
                            @endforeach
                        </div>
                        <div class="mt-3"></div>
                        <form action="{{route('product.description.update')}}" method="post"
                              id="description_form" class="h-100">
                            @csrf
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                            @foreach($locales as $locale)
                                <div class="collapse {{$locale->main==1 ? 'show' : ''}}" id="tab-{{$locale->abbr}}"
                                     data-bs-parent="#tab-group-2" style="">
                                    <div class="content mx-0 ms-0">
                                        <h1 class="font-20 line-height-m pb-2 text-center">
                                            {{__('Description')}} ({{$locale->language}})
                                        </h1>
                                        <div class="divider mt-4"></div>
                                        <input type="hidden" name="description_{{$locale->abbr}}" id="description_{{$locale->abbr}}">
                                        <div id="editor{{$locale->abbr}}">
                                            {!! $product->getTranslation('description',$locale->abbr) !!}
                                        </div>
                                        <div class="d-flex justify-content-center gap-3">

                                            <button   data-bs-dismiss="offcanvas" type="button"
                                                class="default-link btn btn-m rounded-s gradient-highlight shadow-bg shadow-bg-s px-5 mb-0 mt-2">
                                                {{__('Cancel')}}
                                            </button>
                                            <button
                                                class="default-link btn btn-m rounded-s gradient-highlight shadow-bg shadow-bg-s px-5 mb-0 mt-2">
                                                {{__('Update')}}
                                            </button>
                                        </div>
                                        <div class="divider mt-4"></div>
                                    </div>
                                </div>
                            @endforeach
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
