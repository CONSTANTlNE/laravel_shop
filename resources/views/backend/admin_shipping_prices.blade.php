@extends('frontend.components.layout')

@section('admin-shipping-prices')

    <div class="text-center pb-3">
        <h2 class="font-700">Shipping Prices</h2>
    </div>

    <div class="card card-style">
        <div class="d-flex justify-content-center gap-2 mt-3 mb-2">
            {{--  create coupon modal --}}
            <button
                class="btn btn-full btn-s font-900  rounded-sm shadow-l bg-blue-dark mb-1 pt-2 pb-2"
                data-bs-toggle="offcanvas"
                data-bs-target="#create_shipping_price">
                Add Shipping Rate
            </button>

            <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
                 style="width:100%;max-width :400px" id="create_shipping_price">
                <form class="content" action="{{route('shippingprice.store')}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <p class="font-24 font-800 mb-3 text-center">Create Shipping Rate</p>
                    <div class="d-flex justify-content-around">
                        <select required name="city_id" class="form-select rounded-xs w-auto d-inline">
                            @foreach($cities as $city)
                                <option @selected($city->name=='რეგიონი') value="{{$city->id}}">
                                    {{$city->name}}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-custom  form-floating">
                            <input type="text" name="rate"
                                   class="form-control rounded-xs"
                                   id="coupon_percent"
                                   style="width: 100px"
                                   value=""
                                   required
                                   placeholder="%"/>
                            <label for="coupon_percent"
                                   class="color-theme">
                                Rate
                            </label>
                        </div>
                        <div class="form-custom form-floating">
                            <input type="text" name="upper_range"
                                   class="form-control rounded-xs"
                                   id="coupon_percent"
                                   style="width: 100px"
                                   value=""
                                   placeholder="%"/>
                            <label for="coupon_percent"
                                   class="color-theme">
                                Limit
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button
                            {{-- onclick="showOverlay()"--}}
                            class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="content">
            <div class="table-responsive">
                <table class="table color-theme mb-2">
                    <thead>
                    <tr>
                        <th scope="col" class="text-center">
                            <a href="#"
                               class="text-decoration-none"> City
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href="#"
                               class="text-decoration-none"> Rate
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href="#"
                               class="text-decoration-none"> Limit
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href="#"
                               class="text-decoration-none"> Action
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($prices as $index  => $price)
                        <tr>
                            <td class="text-center">
                                {{$price->city->name}}
                            </td>
                            <td class="text-center">{{$price->rate}}</td>
                            <td class="text-center">{{$price->upper_range}}</td>
                            <td class="d-flex justify-content-center gap-2">
                                {{--  delete discount modal --}}
                                <a href="#" data-bs-toggle="offcanvas" data-bs-target="#delete_discount{{$index}}"
                                   class="list-group-item">
                                    <i class="bi bi-trash color-red-dark font-18"></i>
                                </a>

                                <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
                                     style="width:100%;max-width :400px" id="delete_discount{{$index}}">
                                    <form class="content" action="{{route('shippingprice.delete')}}"
                                          method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="{{$price->id}}" name="id">
                                        <p class="font-24 font-800 mb-3 text-center">
                                            Delete Shipping Price for  {{$price->city->name}} ?
                                        </p>
                                        <div class="d-flex justify-content-center gap-4">
                                            <button type="button" data-bs-dismiss="offcanvas"
                                                    class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                                                Cancel
                                            </button>
                                            <button class="btn btn-full gradient-red shadow-bg shadow-bg-s mt-4">
                                                Delete
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <button style="all:unset;cursor:pointer"
                                        class="mb-1"
                                        data-bs-toggle="offcanvas"
                                        data-bs-target="#edit_rate{{$price->id}}">
                                    <i class="bi bi-pencil-square color-blue-dark font-18"></i>
                                </button>
                                <div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme" style="width:100%;max-width :400px" id="edit_rate{{$price->id}}">
                                    <form class="content" action="{{route('shippingprice.update')}}" method="post"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="{{$price->id}}" name="id">
                                        <p class="font-24 font-800 mb-3 text-center">Create Shipping Rate</p>
                                        <div class="d-flex justify-content-around">
                                            <select required name="city_id" class="form-select rounded-xs w-auto d-inline">
                                                @foreach($cities as $city)
                                                    <option @selected($city->id==$price->city_id) value="{{$city->id}}">
                                                        {{$city->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="form-custom  form-floating">
                                                <input type="text" name="rate"
                                                       class="form-control rounded-xs"
                                                       id="coupon_percent"
                                                       style="width: 100px"
                                                       value="{{$price->rate}}"
                                                       required
                                                       placeholder="%"/>
                                                <label for="coupon_percent"
                                                       class="color-theme">
                                                    Rate
                                                </label>
                                            </div>
                                            <div class="form-custom form-floating">
                                                <input type="text" name="upper_range"
                                                       class="form-control rounded-xs"
                                                       id="coupon_percent"
                                                       style="width: 100px"
                                                       value="{{$price->upper_range}}"
                                                       placeholder="%"/>
                                                <label for="coupon_percent"
                                                       class="color-theme">
                                                    Limit
                                                </label>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-center">
                                            <button
                                                {{-- onclick="showOverlay()"--}}
                                                class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                                                update
                                            </button>
                                        </div>
                                    </form>
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

    @push('js')

    @endpush
@endsection
