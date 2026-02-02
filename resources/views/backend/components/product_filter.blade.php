<form method="GET" class="mb-2">
    <div class="d-flex flex-wrap gap-2 justify-content-center align-items-end mb-3">
        <div>
            <label class="d-block small mb-1 text-center">Per Page</label>
            <select name="per_page" class="form-select rounded-xs w-auto d-inline"
                    onchange="this.form.submit()">
                @foreach([10,20, 30, 50, 100] as $size)
                    <option value="{{ $size }}" {{ request('per_page', 20) == $size ? 'selected' : '' }}>
                        {{ $size }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="d-block small mb-1 text-center">Category</label>
            <select name="category_id" class="form-select rounded-xs" onchange="this.form.submit()">
                <option value="">All</option>
                @isset($categories)
                    @foreach($categories as $cat)
                        <option
                            value="{{ $cat->id }}" {{ (string)request()->query('category_id') === (string)$cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                @endisset
            </select>
        </div>
        <div>
            <label class="d-block small mb-1 text-center">Subcategory</label>
            <select name="subcategory_id" class="form-select rounded-xs">
                <option value="">All</option>
                @isset($subcategories)
                    @php $selectedCat = request()->query('category_id'); @endphp
                    @foreach($subcategories as $sub)
                        @if(!$selectedCat || (string)$sub->category_id === (string)$selectedCat)
                            <option
                                value="{{ $sub->id }}" {{ (string)request()->query('subcategory_id') === (string)$sub->id ? 'selected' : '' }}>
                                {{ $sub->name }}
                            </option>
                        @endif
                    @endforeach
                @endisset
            </select>
        </div>
        <div>
            <label class="d-block small mb-1 text-center">Discounts</label>
            <select name="discounts" class="form-select rounded-xs">
                <option
                    value="" {{ request()->query('discounts') === null || request()->query('discounts') === '' ? 'selected' : '' }}>
                    All
                </option>
                <option
                    value="discounted" {{ request()->query('discounts') === 'discounted' ? 'selected' : '' }}>
                    Discounted
                </option>
                <option value="coupons" {{ request()->query('discounts') === 'coupons' ? 'selected' : '' }}>
                    Coupons
                </option>
            </select>
        </div>
        <div>
            <label class="d-block small mb-1 text-center">Filter By</label>
            <select name="status_filter" class="form-select rounded-xs">
                <option value="" {{ request()->query('status_filter') === null || request()->query('status_filter') === '' ? 'selected' : '' }}>
                    All
                </option>
                <option value="in_stock" {{ request()->query('status_filter') === 'in_stock' ? 'selected' : '' }}>
                    In Stock
                </option>
                <option value="show_in_main" {{ request()->query('status_filter') === 'show_in_main' ? 'selected' : '' }}>
                    Show In Main
                </option>
                <option value="featured" {{ request()->query('status_filter') === 'featured' ? 'selected' : '' }}>
                    Featured
                </option>
                <option value="is_present" {{ request()->query('status_filter') === 'is_present' ? 'selected' : '' }}>
                    Is Present
                </option>
                <option value="has_presents" {{ request()->query('status_filter') === 'has_presents' ? 'selected' : '' }}>
                    Has Presents
                </option>
                <option value="discounted" {{ request()->query('status_filter') === 'discounted' ? 'selected' : '' }}>
                    Discounted
                </option>
                <option value="show_in_similar" {{ request()->query('status_filter') === 'show_in_similar' ? 'selected' : '' }}>
                    Show In Similar
                </option>
                <option value="removed_from_store" {{ request()->query('status_filter') === 'removed_from_store' ? 'selected' : '' }}>
                    Removed From Store
                </option>
            </select>
        </div>
        <div class="d-flex flex-wrap gap-2 justify-content-center align-items-end">
            <div>
                <label class="d-block small mb-1 text-center">Min Price</label>
                <input type="number" step="0.01" min="0" name="min_price"
                       value="{{ request()->query('min_price') }}" class="form-control rounded-xs"/>
            </div>
            <div>
                <label class="d-block small mb-1 text-center">Max Price</label>
                <input type="number" step="0.01" min="0" name="max_price"
                       value="{{ request()->query('max_price') }}" class="form-control rounded-xs"/>
            </div>
        </div>
        <input type="hidden" name="sort_by"
               value="{{ request()->query('sort_by', $sortBy ?? 'created_at') }}"/>
        <input type="hidden" name="sort_dir"
               value="{{ request()->query('sort_dir', $sortDir ?? 'desc') }}"/>
    </div>
    <div class="d-flex flex-wrap gap-2 justify-content-center align-items-center mb-2">
        <div class="flex-grow-1" style="min-width: 260px; max-width: 520px;">
            <label class="d-block small mb-1 text-center">Search</label>
            <input type="text" name="q" value="{{ request()->query('q') }}" class="form-control rounded-xs text-center"
                   placeholder="Search by name, SKU, slug, category..." />
        </div>
    </div>
    <div class="d-flex flex-wrap gap-2 justify-content-center align-items-center mb-2">
        <div>
            <label class="d-block small mb-1 text-center">Date From</label>
            <input type="date" name="date_from" value="{{ request()->query('date_from') }}" class="form-control rounded-xs" />
        </div>
        <div>
            <label class="d-block small mb-1 text-center">Date To</label>
            <input type="date" name="date_to" value="{{ request()->query('date_to') }}" class="form-control rounded-xs" />
        </div>
    </div>
    <div class="d-flex gap-2 justify-content-center align-items-center">
        <button class="btn btn-sm btn-primary rounded-xs">Apply</button>
        @php $reset = $resetRoute ?? route('admin.products.all', ['locale'=>app()->getLocale()]); @endphp
        <a class="btn btn-sm btn-secondary rounded-xs" href="{{ $reset }}">Reset</a>
    </div>
</form>
