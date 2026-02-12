
<div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
     style="width:100%;max-width :400px" id="create_user">
    <form class="content" action="{{route('admin.user.store')}}" method="post"
          enctype="multipart/form-data">
        @csrf
        <p class="font-24 font-800 mb-3 text-center">
            {{__('Create User')}}
        </p>
        <div class="d-flex gap-3 mb-3">
            <label for="sku"
                   style="width: 100%"
                   class="color-theme text-start">
                {{__('Name')}}
                <input type="text"
                       name="name"
                       class="form-control rounded-xs"/>
            </label>
        </div>
        <div class="d-flex gap-3 mb-3">
            <label for="sku"
                   style="width: 100%"
                   class="color-theme text-start">{{__('Email')}}
                <input type="text"
                       name="email"
                       class="form-control rounded-xs"/>
            </label>
        </div>
        <div class="d-flex gap-3 mb-3">
            <label for="sku"
                   style="width: 100%"
                   class="color-theme text-start">{{__('Mobile')}}
                <input type="text"
                       name="mobile"
                       class="form-control rounded-xs"/>
            </label>
        </div>
        <div class="d-flex gap-3 mb-3">
            <label for="sku"
                   style="width: 100%"
                   class="color-theme text-start">{{__('Password')}}
                <input type="text"
                       name="password"
                       class="form-control rounded-xs"/>
            </label>
        </div>
        <div class="d-flex gap-3 mb-3">
            <label for="sku"
                   style="width: 100%"
                   class="color-theme text-start">{{__('PID')}}
                <input type="text"
                       name="pid"
                       class="form-control rounded-xs"/>
            </label>
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
