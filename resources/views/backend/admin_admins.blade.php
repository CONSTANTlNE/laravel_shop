@extends('frontend.components.layout')

@section('admin-admins')
    @push('css')

    @endpush
    <div class="card overflow-visible card-style m-0 mb-3">
        <div class="content mb-0">
            <h2 class="text-center">{{__('Admins')}}</h2>
            <div class="d-flex justify-content-center gap-5">
                @include('backend.components.modals.admin_create')
                <div class="d-flex flex-column justify-content-center gap-2">
                    <label class="d-block small mb-1 text-center">{{__('Per Page')}}</label>
                    <select name="per_page" class="form-select rounded-xs w-auto d-inline"
                            onchange="this.form.submit()">
                        @foreach([10,20, 30, 50, 100] as $size)
                            <option value="{{ $size }}" {{ request('per_page', 20) == $size ? 'selected' : '' }}>
                                {{ $size }}
                            </option>
                        @endforeach
                        {{--                            <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>--}}
                        {{--                                All--}}
                        {{--                            </option>--}}
                    </select>
                </div>
            </div>


            <div class="table-responsive mt-3">
                <table class="table color-theme mb-2">
                    <thead>
                    <tr>
                        <th scope="col" class="text-center">
                            <a href=""
                               class="text-decoration-none">
                                Created At
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href=""
                               class="text-decoration-none">Name
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href=""
                               class="text-decoration-none">Email
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href=""
                               class="text-decoration-none">mobile
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href=""
                               class="text-decoration-none">Role
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($admins as $admin)
                        <tr>
                            <td class="text-center">{{$admin->created_at->format('d/m/Y')}}</td>
                            <td class="text-center">{{$admin->name}}</td>
                            <td class="text-center">{{$admin->email}}</td>
                            <td class="text-center">{{$admin->mobile}}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    @include('backend.components.modals.users_role')
                                </div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    @include('backend.components.modals.admins_edit')
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                @if(method_exists($admins, 'links'))
                    <div class="d-flex justify-content-center align-items-center gap-4 mt-3">
                        {{ $admins->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
