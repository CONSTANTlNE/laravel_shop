<button href="#"
        data-bs-toggle="offcanvas"
        data-bs-target="#edit_user_{{$admin->id}}"
        class="btn btn-full btn-s font-900  rounded-sm shadow-l bg-blue-dark  mb-1 pt-2 pb-2">
            Edit
</button>

<div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme"
     style="width:100%;max-width :400px" id="edit_user_{{$admin->id}}">
    <form class="content" action="{{route('admin.admins.update')}}" method="post"
          enctype="multipart/form-data">
        @csrf
        <input type="hidden" value="{{$admin->id}}" name="id">
        <p class="font-24 font-800 mb-3 text-center">
            Create User
        </p>
        <div class="d-flex gap-3 mb-3">
            <label for="sku"
                   style="width: 100%"
                   class="color-theme text-start">Name
                <input type="text"
                       name="name"
                       value="{{$admin->name}}"
                       class="form-control rounded-xs"/>
            </label>
        </div>
        <div class="d-flex gap-3 mb-3">
            <label for="sku"
                   style="width: 100%"
                   class="color-theme text-start">Email
                <input type="text"
                       name="email"
                       value="{{$admin->email}}"
                       class="form-control rounded-xs"/>
            </label>
        </div>
        <div class="d-flex gap-3 mb-3">
            <label for="sku"
                   style="width: 100%"
                   class="color-theme text-start">Mobile
                <input type="text"
                       name="mobile"
                       value="{{$admin->mobile}}"
                       class="form-control rounded-xs"/>
            </label>
        </div>
        <div class="d-flex gap-3 mb-3">
            <label for="sku"
                   style="width: 100%"
                   class="color-theme text-start">Password
                <input type="text"
                       name="password"
                       class="form-control rounded-xs"/>
            </label>
        </div>


        <div class="d-flex justify-content-center">
            <button class="btn btn-full gradient-green shadow-bg shadow-bg-s mt-4">
                Create
            </button>
        </div>
    </form>
</div>
