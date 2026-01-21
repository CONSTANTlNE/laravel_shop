<div class="offcanvas offcanvas-modal rounded-m offcanvas-detached bg-theme w-100"
     style=" max-width:800px; max-height: 78vh; overflow-y: auto; overflow-x: hidden;"
     id="admin_settings">
    <div class="content">
        <div class="d-flex justify-content-center">
            <h5>Settings</h5>
        </div>
        <div class="card p-2 card-style m-0">
            <div id="settings_target"></div>
            <a href="#" data-toast="general_success_toast">toast</a>
            <form class="list-group list-custom list-group-m list-group-flush rounded-xs"
                  method="post"
                  action="{{route('admin.settings.update')}}">
                  @csrf
{{--                  hx-post="{{route('admin.settings.update')}}"--}}
{{--                  hx-trigger="change"--}}
{{--                  hx-target="#settings_target"--}}

{{--                data-toast="general_success_toast"--}}
                <a  href="#" class="list-group-item pe-2" data-trigger-switch="show_only_categories_on_main">
                    <i class="has-bg bg-blue-dark rounded-xs bi bi-gear-fill"></i>
                    <div><strong>Show Only Categories On Main</strong><span>Show Only Categories</span></div>
                    <div class="form-switch ios-switch switch-green switch-m">
                        <input type="checkbox"
                               class="ios-input"
                               name="show_only_categories_on_main"
                               id="show_only_categories_on_main"
{{--                                                           onchange="this.form.submit()"--}}
                            @checked($site_settings->show_only_categories_on_main)>
                        <label class="custom-control-label" for="sku-switch"></label>
                    </div>
                </a>
                <a  href="#" class="list-group-item pe-2" data-trigger-switch="sku-switch">
                    <i class="has-bg bg-blue-dark rounded-xs bi bi-gear-fill"></i>
                    <div><strong>Use Sku </strong><span>use_sku</span></div>
                    <div class="form-switch ios-switch switch-green switch-m">
                        <input type="checkbox"
                               class="ios-input"
                               name="use_sku"
                               id="sku-switch"
                            {{--                               onchange="this.form.submit()"--}}
                            @checked($site_settings->use_sku)>
                        <label class="custom-control-label" for="sku-switch"></label>
                    </div>
                </a>
                <a  href="#" class="list-group-item pe-2" data-trigger-switch="use_stock">
                    <i class="has-bg bg-blue-dark rounded-xs bi bi-gear-fill"></i>
                    <div><strong>Use Stok </strong><span>use_stock</span></div>
                    <div class="form-switch ios-switch switch-green switch-m">
                        <input type="checkbox"
                               class="ios-input"
                               name="use_stock"
                               id="use_stock"
                            {{--                               onchange="this.form.submit()"--}}
                            @checked($site_settings->use_stock)>
                        <label class="custom-control-label" for="use_stock"></label>
                    </div>
                </a>
                <a  href="#" class="list-group-item pe-2" data-trigger-switch="show_discounted">
                    <i class="has-bg bg-blue-dark rounded-xs bi bi-gear-fill"></i>
                    <div><strong>Show Discounted</strong><span>show_discounted</span></div>
                    <div class="form-switch ios-switch switch-green switch-m">
                        <input type="checkbox"
                               class="ios-input"
                               name="show_discounted"
                               id="show_discounted"
                            {{--                               onchange="this.form.submit()"--}}
                            @checked($site_settings->show_discounted)>
                        <label class="custom-control-label" for="show_discounted"></label>
                    </div>
                </a>
                <a  href="#" class="list-group-item pe-2" data-trigger-switch="show_discount_percent">
                    <i class="has-bg bg-blue-dark rounded-xs bi bi-gear-fill"></i>
                    <div><strong>show discount percent</strong><span>Use Stok</span></div>
                    <div class="form-switch ios-switch switch-green switch-m">
                        <input type="checkbox"
                               class="ios-input"
                               name="show_discount_percent"
                               id="show_discount_percent"
                            {{-- onchange="this.form.submit()" --}}
                            @checked($site_settings->show_discount_percent)>
                        <label class="custom-control-label" for="show_discount_percent"></label>
                    </div>
                </a>
                <a  href="#" class="list-group-item pe-2" data-trigger-switch="show_faq">
                    <i class="has-bg bg-blue-dark rounded-xs bi bi-gear-fill"></i>
                    <div><strong>Show FAQ</strong><span>Use Stok</span></div>
                    <div class="form-switch ios-switch switch-green switch-m">
                        <input type="checkbox"
                               class="ios-input"
                               name="show_faq"
                               id="show_faq"
                            {{-- onchange="this.form.submit()" --}}
                            @checked($site_settings->show_faq)>
                        <label class="custom-control-label" for="show_faq"></label>
                    </div>
                </a>
                <a  href="#" class="list-group-item pe-2" data-trigger-switch="use_categories">
                    <i class="has-bg bg-blue-dark rounded-xs bi bi-gear-fill"></i>
                    <div><strong>Use Categories</strong><span>Use Stok</span></div>
                    <div class="form-switch ios-switch switch-green switch-m">
                        <input type="checkbox"
                               class="ios-input"
                               name="use_categories"
                               id="use_categories"
                            {{-- onchange="this.form.submit()" --}}
                            @checked($site_settings->use_categories)>
                        <label class="custom-control-label" for="use_categories"></label>
                    </div>
                </a>
                <a  href="#" class="list-group-item pe-2" data-trigger-switch="use_transportation">
                    <i class="has-bg bg-blue-dark rounded-xs bi bi-gear-fill"></i>
                    <div><strong>Use Transportation</strong><span>Use Stok</span></div>
                    <div class="form-switch ios-switch switch-green switch-m">
                        <input type="checkbox"
                               class="ios-input"
                               name="use_transportation"
                               id="use_transportation"
                            {{-- onchange="this.form.submit()" --}}
                            @checked($site_settings->use_transportation)>
                        <label class="custom-control-label" for="use_transportation"></label>
                    </div>
                </a>
                <a  href="#" class="list-group-item pe-2" data-trigger-switch="use_email_notification">
                    <i class="has-bg bg-blue-dark rounded-xs bi bi-gear-fill"></i>
                    <div><strong>use_email_notification</strong><span>Use Stok</span></div>
                    <div class="form-switch ios-switch switch-green switch-m">
                        <input type="checkbox"
                               class="ios-input"
                               name="use_email_notification"
                               id="use_email_notification"
                            {{-- onchange="this.form.submit()" --}}
                            @checked($site_settings->use_email_notification)>
                        <label class="custom-control-label" for="use_email_notification"></label>
                    </div>
                </a>
                <a href="#" class="list-group-item pe-2" data-trigger-switch="sms_notification">
                    <i class="has-bg bg-blue-dark rounded-xs bi bi-gear-fill"></i>
                    <div><strong>sms_notification</strong><span>Use Stok</span></div>
                    <div class="form-switch ios-switch switch-green switch-m">
                        <input type="checkbox"
                               class="ios-input"
                               name="sms_notification"
                               id="sms_notification"
                            {{-- onchange="this.form.submit()" --}}
                            @checked($site_settings->sms_notification)>
                        <label class="custom-control-label" for="sms_notification"></label>
                    </div>
                </a>
                <a  href="#" class="list-group-item pe-2" data-trigger-switch="dark_theme">
                    <i class="has-bg bg-blue-dark rounded-xs bi bi-gear-fill"></i>
                    <div><strong>Dark Theme</strong><span>Dark Theme</span></div>
                    <div class="form-switch ios-switch switch-green switch-m">
                        <input type="checkbox"
                               class="ios-input"
                               name="dark_theme"
                               id="dark_theme"
                            {{-- onchange="this.form.submit()" --}}
                            @checked($site_settings->dark_theme)>
                        <label class="custom-control-label" for="dark_theme"></label>
                    </div>
                </a>
                <a  href="#" class="list-group-item pe-2" data-trigger-switch="use_main_banner">
                    <i class="has-bg bg-blue-dark rounded-xs bi bi-gear-fill"></i>
                    <div><strong>Use Main Banner</strong><span>Use Main Banner</span></div>
                    <div class="form-switch ios-switch switch-green switch-m">
                        <input type="checkbox"
                               class="ios-input"
                               name="use_main_banner"
                               id="use_main_banner"

                            {{-- onchange="this.form.submit()" --}}
                            @checked($site_settings->use_main_banner)>
                        <label class="custom-control-label" for="use_main_banner"></label>
                    </div>
                </a>
                <a  href="#" class="list-group-item pe-2" data-trigger-switch="use_sms_verification">
                    <i class="has-bg bg-blue-dark rounded-xs bi bi-gear-fill"></i>
                    <div><strong>Use SMS Verification</strong><span>Use SMS Verification</span></div>
                    <div class="form-switch ios-switch switch-green switch-m">
                        <input type="checkbox"
                               class="ios-input"
                               name="use_sms_verification"
                               id="use_sms_verification"

                            {{-- onchange="this.form.submit()" --}}
                            @checked($site_settings->use_sms_verification)>
                        <label class="custom-control-label" for="use_sms_verification"></label>
                    </div>
                </a>

                <div class="d-flex flex-column justify-content-center align-items-center mt-2">
                    <p class="text-center mb-0">Minimum Order Amount</p>
                    <div class="d-flex justify-content-center  align-items-center gap-2">
                        <div class="form-custom  mb-3 mt-3">
                            <input type="number" name="min_order_amount" class="form-control rounded-xs" id="moq" min="0" value="{{$site_settings->min_order_amount}}">
                        </div>
                        <button style="max-height: 50px"
{{--                                hx-post="{{route('admin.settings.update')}}"--}}
{{--                                hx-target="#settings_target"--}}

                                class="default-link btn btn-m rounded-s gradient-highlight shadow-bg shadow-bg-s px-5 mb-0">
                            Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
