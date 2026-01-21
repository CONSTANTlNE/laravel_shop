
<div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme w-100"
     style="max-width:800px; max-height: 90vh; overflow-y: auto; overflow-x: hidden;"
     id="order_items_{{$user->id}}">
    <div class="card overflow-visible card-style mb-0"
         style="margin-right: 0;margin-left: 0">
        <div class="content">
            <h4>{{$user->name}} - {{__('Orders Items')}}</h4>
            <div class="border border-blue-dark rounded-s overflow-hidden" id="order_target_{{$user->id}}">


            </div>
        </div>
    </div>
</div>
