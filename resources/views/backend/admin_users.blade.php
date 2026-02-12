@extends('frontend.components.layout')

@section('admin-users')
    @push('css')
    @endpush
    <div class="card overflow-visible card-style m-0 mb-3">
        <div class="content mb-0">
            <div class="d-flex justify-content-center gap-4 mb-2">
                <button
                    data-bs-toggle="offcanvas"
                    data-bs-target="#create_user"
                    class="btn  bg-highlight shadow-bg shadow-bg-s pt-2 pb-2">
                    {{__('Create User')}}
                </button>
                @include('backend.components.modals.users_create')
                <h2 class="text-center mb-0">{{__('Users')}}</h2>
            </div>

            <div class="d-flex justify-content-center gap-5">

                <div class="d-flex flex-column justify-content-center gap-2">
                    <label class="d-block small mb-1 text-center">{{__('Per Page')}}</label>
                    <select name="per_page" class="form-select rounded-xs w-auto d-inline"
                            onchange="this.form.submit()">
                        @foreach([10,20, 30, 50, 100] as $size)
                            <option value="{{ $size }}" {{ request('per_page', 20) == $size ? 'selected' : '' }}>
                                {{ $size }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="table-responsive mt-3">
                <table class="table color-theme mb-2">
                    <thead>
                    <tr>
                        <th scope="col" class="text-center">
                            <a href="" class="text-decoration-none">
                                {{__('Created At')}}
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href="" class="text-decoration-none">
                                {{__('Name')}}
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href="" class="text-decoration-none">
                                {{__('Email')}}
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href="" class="text-decoration-none">
                                {{__('Mobile')}}
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href="" class="text-decoration-none">
                                {{__('PID')}}
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            <a href="" class="text-decoration-none">
                                {{__('Orders')}}
                            </a>
                        </th>
                        <th scope="col" class="text-center">
                            {{__('Action')}}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="text-center">{{$user->created_at->format('d/m/Y')}}</td>
                            <td class="text-center">{{$user->name}}</td>
                            <td class="text-center">{{$user->email}}</td>
                            <td class="text-center">{{$user->mobile}}</td>
                            <td class="text-center">{{$user->pid}}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    @include('backend.components.modals.user_orders_modal')
                                    @include('backend.components.modals.user_order_items_modal')
                                </div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    @include('backend.components.modals.users_edit')
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if(method_exists($users, 'links'))
                    <div class="d-flex justify-content-center align-items-center gap-4 mt-3">
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
