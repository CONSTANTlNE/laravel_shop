<?php

use App\Models\Admin;
use App\Models\Category;
use App\Models\CategoryOrder;
use App\Models\Language;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Subcategory;
use Illuminate\Support\Str;

function seedBasics(): void
{
    // Languages (controller expects main where main = 0)
    Language::create([
        'abbr' => 'en',
        'language' => 'English',
        'active' => 1,
        'main' => 0,
        'icon' => '🇬🇧',
        'position' => 1,
    ]);

    // Global settings
    Setting::create([]);
}

test('categories index shows categories list view', function () {
    seedBasics();

    $order = CategoryOrder::create(['order' => 1]);

    // Create a couple of categories
    Category::create([
        'name' => ['en' => 'Home'],
        'active' => 1,
        'slug' => 'home',
        'order' => 1,
    ]);

    Category::create([
        'name' => ['en' => 'Garden'],
        'active' => 1,
        'slug' => 'garden',
        'order' => 2,
    ]);

    $this->withoutMiddleware();

    $response = $this->get('/en/categories');

    $response->assertOk()
        ->assertViewIs('frontend.categories.frontend_categories')
        ->assertViewHas('categories')
        ->assertViewHas('categoriesCount', 2);
});

test('category page by category slug returns products with filters and sorting', function () {
    seedBasics();

    $admin = Admin::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => bcrypt('secret')]);
    $order = CategoryOrder::create(['order' => 1]);

    $category = Category::create([
        'name' => ['en' => 'Electronics'],
        'active' => 1,
        'slug' => 'electronics',
        'order' => 1,
    ]);

    // Two products attached via pivot to the category
    $pCheap = Product::create([
        'sku' => 'P1',
        'admin_id' => $admin->id,
        'name' => ['en' => 'Phone'],
        'description' => ['en' => 'Smartphone'],
        'order' => 1,
        'price' => 100,
        'price_history' => [],
        'slug' => Str::slug('Phone'),
    ]);

    $pExp = Product::create([
        'sku' => 'P2',
        'admin_id' => $admin->id,
        'name' => ['en' => 'Laptop'],
        'description' => ['en' => 'Gaming laptop'],
        'order' => 2,
        'price' => 2000,
        'price_history' => [],
        'slug' => Str::slug('Laptop'),
    ]);

    // Attach via pivot so Category::products() sees them
    // $category->categories()->sync([]); // no-op safeguard
    $category->products()->attach([$pCheap->id, $pExp->id]);

    $this->withoutMiddleware();

    // No filters
    $response = $this->get("/en/categories/{$category->slug}");

    $response->assertOk()
        ->assertViewIs('frontend.categories.category_single')
        ->assertViewHasAll(['category', 'productsCount', 'categoriesCount', 'category_orders', 'settings', 'subcategories']);

    $categoryFromView = $response->viewData('category');
    expect($categoryFromView->relationLoaded('products'))->toBeTrue();

    // With min_price filter to exclude cheap product
    $responseMin = $this->get("/en/categories/{$category->slug}?min_price=150");
    $catMin = $responseMin->viewData('category');
    $pricesMin = $catMin->getRelation('products')->pluck('price')->all();
    expect($pricesMin)->toEqual([2000.0]);

    // With max_price filter to exclude expensive product
    $responseMax = $this->get("/en/categories/{$category->slug}?max_price=500");
    $catMax = $responseMax->viewData('category');
    $pricesMax = $catMax->getRelation('products')->pluck('price')->all();
    expect($pricesMax)->toEqual([100.0]);

    // With sort desc by price
    $responseSortDesc = $this->get("/en/categories/{$category->slug}?sort=desc");
    $catSortDesc = $responseSortDesc->viewData('category');
    $pricesDesc = $catSortDesc->getRelation('products')->pluck('price')->all();
    expect($pricesDesc)->toEqual([2000.0, 100.0]);
});

test('category page falls back to subcategory slug and sets empty subcategories relation', function () {
    seedBasics();

    $admin = Admin::create(['name' => 'Admin', 'email' => 'admin2@example.com', 'password' => bcrypt('secret')]);
    $order = CategoryOrder::create(['order' => 1]);

    $category = Category::create([
        'name' => ['en' => 'Home'],
        'active' => 1,
        'slug' => 'home',
        'order' => 1,
    ]);

    $subcategory = Subcategory::create([
        'name' => ['en' => 'Kitchen'],
        'category_id' => $category->id,
        'order' => 1,
        'active' => 1,
        'slug' => 'kitchen-sub',
    ]);

    // Products under the subcategory
    $p1 = Product::create([
        'sku' => 'S1',
        'admin_id' => $admin->id,
        'subcategory_id' => $subcategory->id,
        'name' => ['en' => 'Spoon'],
        'description' => ['en' => 'Metal spoon'],
        'order' => 1,
        'price' => 5,
        'price_history' => [],
        'slug' => 'spoon',
    ]);

    $p2 = Product::create([
        'sku' => 'S2',
        'admin_id' => $admin->id,
        'subcategory_id' => $subcategory->id,
        'name' => ['en' => 'Pan'],
        'description' => ['en' => 'Frying pan'],
        'order' => 2,
        'price' => 25,
        'price_history' => [],
        'slug' => 'pan',
    ]);

    $this->withoutMiddleware();

    $response = $this->get("/en/categories/{$subcategory->slug}");

    $response->assertOk()
        ->assertViewIs('frontend.categories.category_single')
        ->assertViewHasAll(['category', 'productsCount', 'categoriesCount', 'category_orders', 'settings', 'subcategories']);

    $model = $response->viewData('category');
    // The controller sets the relation to an empty collection for subcategory
    expect($model->getRelation('subcategories'))->toHaveCount(0);
    $prices = $model->getRelation('products')->pluck('price')->all();
    expect($prices)->toEqual([5.0, 25.0]);
});

test('unknown category slug redirects back with error', function () {
    seedBasics();

    $this->withoutMiddleware();

    // Simulate coming from categories page so back() knows where to redirect
    $response = $this->from('/en/categories')
        ->get('/en/categories/not-existing');

    $response->assertRedirect('/en/categories');
    $response->assertSessionHas('alert_error');
});
