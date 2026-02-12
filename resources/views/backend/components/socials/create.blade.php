

<div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
     style="width:100%;max-width :400px" id="create_social">
    <form class="content" action="{{ route('socials.store', ['locale' => app()->getLocale()]) }}" method="post">
        @csrf
        <p class="font-24 font-800 mb-3 text-center">
            {{__('Add Social')}}
        </p>

        <div class="d-flex gap-3 mb-3">
            <label style="width: 100%" class="color-theme text-start">
                {{__('Name')}}
                <input type="text" name="name" class="form-control rounded-xs" required/>
            </label>
        </div>

        <div class="d-flex gap-3 mb-3">
            <label style="width: 100%" class="color-theme text-start">
                {{__('Icon (SVG code)')}}
                <textarea name="icon" class="form-control rounded-xs" rows="3" required></textarea>
            </label>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <label style="width: 100%" class="color-theme text-start">
                    {{__('Width')}}
                    <input type="number" name="width" class="form-control rounded-xs"/>
                </label>
            </div>
            <div class="col-6">
                <label style="width: 100%" class="color-theme text-start">
                    {{__('Height')}}
                    <input type="number" name="height" class="form-control rounded-xs"/>
                </label>
            </div>
        </div>

        <div class="d-flex gap-3 mb-3">
            <label style="width: 100%" class="color-theme text-start">
                {{__('URL')}}
                <input type="text" name="url" class="form-control rounded-xs"/>
            </label>
        </div>

        <div class="d-flex mb-4">
            <div class="pt-1">
                <h5 class="font-500 font-14">{{ __('Is Active') }}</h5>
            </div>
            <div class="ms-auto">
                <div class="custom-control ios-switch">
                    <input type="checkbox" name="is_active" class="ios-input" id="add-is-active" checked>
                    <label class="custom-control-label" for="add-is-active"></label>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-2 gap-2">
            <button type="button" data-bs-dismiss="offcanvas" class="btn btn-full bg-highlight shadow-bg shadow-bg-s">
                დახურვა
            </button>
            <button onclick="onSubmit(this.form,this,'{{__('Creating')}}')" class="btn btn-full gradient-green shadow-bg shadow-bg-s">
                {{__('Create')}}
            </button>
        </div>
    </form>

</div>
