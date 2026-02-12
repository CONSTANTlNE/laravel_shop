<button href="#"
        data-bs-toggle="offcanvas"
        data-bs-target="#edit_social_{{$social->id}}"
        class="icon icon-xs rounded-s bg-green-dark shadow-l border-0">
    <i class="bi bi-pencil-square font-20"></i>
</button>

<div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
     style="width:100%;max-width:400px" id="edit_social_{{$social->id}}">
    <form class="content" action="{{ route('socials.update', ['locale' => app()->getLocale()]) }}" method="post">
        @csrf
        <input type="hidden" name="social_id" value="{{ $social->id }}">
        <p class="font-24 font-800 mb-3 text-center">
            {{__('Update Social')}}
        </p>

        <div class="d-flex gap-3 mb-3">
            <label style="width: 100%" class="color-theme text-start">
                {{__('Name')}}
                <input type="text" name="name" value="{{ $social->name }}" class="form-control rounded-xs" required/>
            </label>
        </div>

        <div class="d-flex gap-3 mb-3">
            <label style="width: 100%" class="color-theme text-start">
                {{__('Icon (SVG code)')}}
                <textarea name="icon" class="form-control rounded-xs" rows="3" required>{{ $social->icon }}</textarea>
            </label>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <label style="width: 100%" class="color-theme text-start">
                    {{__('Width')}}
                    <input type="number" name="width" value="{{ $social->width }}" class="form-control rounded-xs"/>
                </label>
            </div>
            <div class="col-6">
                <label style="width: 100%" class="color-theme text-start">
                    {{__('Height')}}
                    <input type="number" name="height" value="{{ $social->height }}" class="form-control rounded-xs"/>
                </label>
            </div>
        </div>

        <div class="d-flex gap-3 mb-3">
            <label style="width: 100%" class="color-theme text-start">
                {{__('URL')}}
                <input type="text" name="url" value="{{ $social->url }}" class="form-control rounded-xs"/>
            </label>
        </div>

        <div class="d-flex justify-content-center gap-3 mb-4">
            <div class="pt-1">
                <h5 class="font-500 font-14">{{ __('Is Active') }}</h5>
            </div>

                <div class="custom-control ios-switch">
                    <input type="checkbox" name="is_active" class="ios-input" id="edit-active-{{ $social->id }}" {{ $social->is_active ? 'checked' : '' }}>
                    <label class="custom-control-label" for="edit-active-{{ $social->id }}"></label>
                </div>

        </div>

        <div class="d-flex justify-content-center mt-2 gap-2">
            <button type="button" data-bs-dismiss="offcanvas" class="btn btn-full bg-highlight shadow-bg shadow-bg-s">
                დახურვა
            </button>
            <button onclick="onSubmit(this.form,this,'{{__('Creating')}}')" class="btn btn-full gradient-green shadow-bg shadow-bg-s">
                {{__('Update')}}
            </button>
        </div>
    </form>
</div>
