@extends('frontend.components.layout')

@section('site-data')
    <div class="card card-style">
        <div class="content">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>{{ __('Social Links') }}</h4>
                <button
                    data-bs-toggle="offcanvas"
                    data-bs-target="#create_social"
                    class="btn  bg-highlight shadow-bg shadow-bg-s pt-2 pb-2">
                    {{__('Create')}}
                </button>

            </div>

            @include('backend.components.socials.create')

            <div class="table-responsive">
                <table class="table color-theme mb-2">
                    <thead>
                    <tr>
                        <th scope="col">{{ __('Name') }}</th>
                        <th scope="col">{{ __('Icon') }}</th>
                        <th scope="col">{{ __('Dimensions') }}</th>
                        <th scope="col">{{ __('URL') }}</th>
                        <th scope="col" class="text-center">{{ __('Active') }}</th>
                        <th scope="col" class="text-center">{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($socials as $social)
                        @php

                            $svg = $social->icon; // SVG stored in the database
                            $newWidth =  $social->width;
                            $newHeight = $social->height;

                        $svg = preg_replace('/width="\d+(\.\d+)?(px)?"/i', 'width="'.$newWidth.'"', $svg);
                        $svg = preg_replace('/height="\d+(\.\d+)?(px)?"/i', 'height="'.$newHeight.'"', $svg);

                        @endphp

                        <tr>
                            <td>{{ $social->name }}</td>
                            <td>
                                <div class="d-flex justify-content-center align-items-center">
                                    {!! $svg !!}
                                </div>
                            </td>
                            <td>{{ $social->width }}x{{ $social->height }}</td>
                            <td class="text-truncate" style="max-width: 150px;">{{ $social->url }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    <div class="custom-control ios-switch">
                                        <input type="checkbox" class="ios-input" id="social-active-{{ $social->id }}"
                                               {{ $social->is_active ? 'checked' : '' }} disabled>
                                        <label class="custom-control-label"
                                               for="social-active-{{ $social->id }}"></label>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    @include('backend.components.socials.edit')

                                    <form action="{{ route('socials.delete', ['locale' => app()->getLocale()]) }}"
                                          method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                        @csrf
                                        <input type="hidden" name="social_id" value="{{ $social->id }}">
                                        <button type="submit"
                                                class="icon icon-xs rounded-s bg-red-dark shadow-l border-0">
                                            <i class="bi bi-trash font-20"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
