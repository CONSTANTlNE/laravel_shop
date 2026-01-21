@extends('frontend.components.layout')

@section('admin-banners')

    <div class="card overflow-visible card-style m-0 mb-3">
        <div class="content mb-0">
            <div class="d-flex justify-content-center gap-2 align-items-center">
                <div class="text-center">
                    <h4>{{__('Banners')}}</h4>
                    <button
                        class="btn btn-full btn-s font-900  rounded-sm shadow-l bg-blue-dark mb-1 pt-2 pb-2 mt-2"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#create_banner">
                        {{__('Create Banner')}}
                    </button>
                </div>
                {{--  edit name modal --}}
                <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
                     style="width:100%;max-width :400px" id="create_banner">
                    <form class="content" action="{{route('admin.banners.create')}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <p class="font-24 font-800 mb-3 text-center">{{__('Create Banner')}}</p>
                        @foreach($locales as $locale)
                            <div class="form-custom mb-3 form-floating">
                                <input type="text" name="header_{{$locale->abbr}}"
                                       class="form-control rounded-xs"
                                       id="c1{{$locale->abbr}}"
                                       {{--                                       @required($locale->main==1)--}}
                                       value="{{old('header_'.$locale->abbr)}}"
                                       placeholder="{{__('Title')}}"/>
                                <label for="c1{{$locale->abbr}}"
                                       class="color-theme">{{__('Title')}} {{$locale->language}} </label>
                                @if($locale->main==1)
                                    {{--                                    <span>({{__('required')}})</span>--}}
                                @endif
                            </div>
                            <div class="form-custom mb-3 form-floating">
                                <i class="bi bi-pencil-fill font-12 disabled"></i>
                                <textarea class="form-control rounded-xs"
                                          placeholder="Leave a comment here"
                                          name="description_{{$locale->abbr}}"
                                          {{--                                          @required($locale->main==1)--}}
                                          id="c7{{$locale->abbr}}">{{old('description_'.$locale->abbr)}}</textarea>
                                <label for="c7{{$locale->abbr}}"
                                       class="color-theme">{{__('Description')}} {{$locale->language}}</label>
                                @if($locale->main==1)
                                    {{--                                    <span>({{__('required')}})</span>--}}
                                @endif
                            </div>
                        @endforeach

                        <input type="file" name="image"
                               class="form-control rounded-xs mt-4"
                               id="image"/>


                        <div class="d-flex justify-content-center">
                            <button
                                {{--                                onclick="showOverlay()"--}}
                                class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                                {{__('Create')}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>


            <div class="table-responsive">
                <table class="table color-theme mb-2">
                    <thead>
                    <tr>
                        <th scope="col" class="text-center">
                            {{__('Title')}}
                        </th>
                        <th scope="col" class="text-center">
                            {{__('Description')}}
                        </th>
                        <th scope="col" class="text-center">
                            {{__('Active')}}
                        </th>
                        <th scope="col" class="text-center">
                            {{__('Image')}}
                        </th>
                        <th scope="col" class="text-center">
                            <a href="#"
                               class="text-decoration-none">
                                {{__('Action')}}
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($banners as $index => $banner)
                        <tr>
                            <td class="text-center align-middle">{{$banner->header}}</td>
                            <td class="text-center align-middle">{{$banner->description}}</td>
                            <td class="text-center align-middle">
                                <form action="{{route('admin.banners.activate')}}" method="post"
                                      class="d-flex justify-content-center">
                                    @csrf
                                    <input type="hidden" name="banner_id" value="{{$banner->id}}">

                                    <div class="form-switch ios-switch switch-green switch-l">
                                        <input type="checkbox" class="ios-input"
                                               id="switch-4c{{$banner->id}}"
                                               @checked($banner->is_active==1)
                                               onchange="this.form.submit()">
                                        <label class="custom-control-label"
                                               for="switch-4c{{$banner->id}}"></label>
                                    </div>
                                </form>
                            </td>
                            <td class="text-center align-middle">
                                <img src="{{$banner->getFirstMedia('banner_image')?->getUrl()}}"
                                     style="height: 150px;width: 150px" alt="">
                            </td>
                            <td class="text-center align-middle">
                                {{--  edit discount modal --}}
                                <div class=" d-flex justify-content-center  gap-2">
                                    <button style="all:unset;cursor:pointer"
                                            class="mb-1" data-bs-toggle="offcanvas"
                                            data-bs-target="#edit_discount{{$index}}">
                                        <i class="bi bi-pencil-square color-blue-dark font-30"></i>
                                    </button>
                                    <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
                                         style="width:100%;max-width :400px" id="edit_discount{{$index}}">

                                        <form class="content" action="{{route('admin.banners.update')}}" method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="banner_id" value="{{$banner->id}}">
                                            <p class="font-24 font-800 mb-3 text-center">Create Banner</p>
                                            @foreach($locales as $locale)
                                                <div class="form-custom mb-3 form-floating">
                                                    <input type="text" name="header_{{$locale->abbr}}"
                                                           class="form-control rounded-xs"
                                                           id="c1{{$locale->abbr}}"
{{--                                                           @required($locale->main==1)--}}
                                                           value="{{$banner->getTranslation('header',$locale->abbr)}}"
                                                           placeholder="Header"/>
                                                    <label for="c1{{$locale->abbr}}"
                                                           class="color-theme">Title {{$locale->language}} </label>
                                                    @if($locale->main==1)
{{--                                                        <span>({{__('required')}})</span>--}}
                                                    @endif
                                                </div>
                                                <div class="form-custom mb-3 form-floating">
                                                    <i class="bi bi-pencil-fill font-12 disabled"></i>
                                                    <textarea class="form-control rounded-xs"
                                                              placeholder="Leave a comment here"
                                                              name="description_{{$locale->abbr}}"
{{--                                                              @required($locale->main==1)--}}
                                                              id="c7{{$locale->abbr}}">{{$banner->getTranslation('description',$locale->abbr)}}</textarea>
                                                    <label for="c7{{$locale->abbr}}"
                                                           class="color-theme">Description {{$locale->language}}</label>
                                                    @if($locale->main==1)
{{--                                                        <span>({{__('required')}})</span>--}}
                                                    @endif
                                                </div>
                                            @endforeach

                                            <input type="file" name="image"
                                                   class="form-control rounded-xs mt-4"
                                                   id="image"/>
                                            <div class="d-flex justify-content-center">
                                                <button
                                                    onclick="showOverlay()"
                                                    class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                                                    {{__('Update')}}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    {{--  delete banner modal --}}
                                    <a href="#" data-bs-toggle="offcanvas" data-bs-target="#delete_{{$index}}"
                                       class="list-group-item">
                                        <i class="bi bi-trash color-red-dark font-30"></i>
                                    </a>
                                    <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
                                         style="width:100%;max-width :400px" id="delete_{{$index}}">
                                        <form class="content" action="{{route('admin.banners.delete')}}"
                                              method="post">
                                            @csrf
                                            <input type="hidden" value="2" name="banner_id">
                                            <p class="font-24 font-800 mb-3 text-center">
                                                {{__('Are You Sure')}} ?
                                            </p>
                                            <div class="d-flex justify-content-center gap-4">
                                                <button type="button" data-bs-dismiss="offcanvas"
                                                        class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                                                    {{__('Cancel')}}
                                                </button>
                                                <button
                                                    onclick="showOverlay()"
                                                    class="btn btn-full gradient-red shadow-bg shadow-bg-s mt-4">
                                                    {{__('Delete')}}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{--                @if(method_exists($categories, 'links'))--}}
                {{--                    <div class="d-flex justify-content-center align-items-center gap-4 mt-3">--}}
                {{--                        {{ $categories->appends(request()->query())->links() }}--}}
                {{--                    </div>--}}
                {{--                @endif--}}
            </div>
        </div>
    </div>

@endsection
