<?php

namespace App\Http\Controllers;

use App\Exports\TotalSalesExport;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Discount;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Subcategory;
use App\Models\User;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function soldProducts(Request $request)
    {
        $data = (new AdminService)->soldProducts($request);
        $order_items = $data['order_items'];
        $sortBy = $data['sortBy'];
        $sortDir = $data['sortDir'];

        // For filters dropdowns
        $categories = Category::orderBy('order')->get(['id', 'name']);
        $subcategories = Subcategory::orderBy('order')->get(['id', 'name', 'category_id']);

        return view('backend.admin_sold_products', compact('order_items', 'sortBy', 'sortDir', 'categories', 'subcategories'));
    }

    public function allProducts(Request $request)
    {

        $data = (new AdminService)->allProducts($request);

        $categories = Category::orderBy('order')->get(['id', 'name']);
        $subcategories = Subcategory::orderBy('order')->get(['id', 'name', 'category_id']);
        $discounts = Discount::where('active', 1)->get();
        $count = Product::count();
        $coupons = Coupon::where('active', 1)->get();

        $products = $data['products'];
        $sortBy = $data['sortBy'];
        $sortDir = $data['sortDir'];

        return view('backend.admin_products', compact('products', 'categories', 'subcategories', 'sortBy', 'sortDir', 'count', 'discounts', 'coupons'));
    }

    public function removedProducts(Request $request)
    {
        $data = (new AdminService)->removedProducts($request);

        $categories = Category::orderBy('order')->get(['id', 'name']);
        $subcategories = Subcategory::orderBy('order')->get(['id', 'name', 'category_id']);
        $discounts = Discount::where('active', 1)->get();
        $count = Product::where('removed_from_store', true)->count();
        $coupons = Coupon::where('active', 1)->get();

        $products = $data['products'];
        $sortBy = $data['sortBy'];
        $sortDir = $data['sortDir'];

        return view('backend.admin_products_removed', compact('products', 'categories', 'subcategories', 'sortBy', 'sortDir', 'count', 'discounts', 'coupons'));
    }

    public function soldSum(Request $request)
    {
        $perPage = (int) $request->query('per_page', 20);
        if ($perPage < 1) {
            $perPage = 10;
        }
        if ($perPage > 100) {
            $perPage = 100;
        }

        $sortBy = $request->query('sort_by', 'product_name');
        $sortDir = strtolower($request->query('sort_dir', 'desc')) === 'asc' ? 'asc' : 'desc';

        $allowedSorts = [
            'product_name',
            'category_name',
            'subcategory_name',
            'total_quantity',
            'total_amount',
            'sales_count',
        ];
        if (! in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'total_quantity';
        }

        //        61310353

        $locale = app()->getLocale();

        $query = OrderItem::query()
            ->leftJoin('products', 'order_items.product_id', '=', 'products.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('subcategories', 'products.subcategory_id', '=', 'subcategories.id')
            ->selectRaw('
        order_items.product_id,
        products.sku as sku,
        products.slug as slug,
        SUM(order_items.quantity) as total_quantity,
        SUM(order_items.product_price * order_items.quantity) as total_amount,
        COUNT(order_items.id) as sales_count
    ')
            ->selectRaw("products.name ->> '{$locale}' as product_name")
            ->selectRaw("categories.name ->> '{$locale}' as category_name")
            ->selectRaw("subcategories.name ->> '{$locale}' as subcategory_name")
            ->groupBy(
                'order_items.product_id',
                'products.sku',
                'products.slug',
                'product_name',
                'category_name',
                'subcategory_name'
            );

        $search = trim($request->query('search', ''));

        if ($search !== '') {

            $query->where(function ($q) use ($search, $locale) {
                $q->whereRaw("products.name ->> '{$locale}' ILIKE ?", ["%{$search}%"])
                    ->orWhere('products.sku', 'ILIKE', "%{$search}%")
                    ->orWhere('products.slug', 'ILIKE', "%{$search}%")
                    ->orWhereExists(function ($sub) use ($search) {
                        $sub->selectRaw('1')
                            ->from('orders')
                            ->whereColumn('orders.id', 'order_items.order_id')
                            ->where('orders.order_token', 'ILIKE', "%{$search}%");
                    });
            });
        }

        $minPrice = $request->query('min_price');
        $maxPrice = $request->query('max_price');
        if (is_numeric($minPrice)) {
            $query->havingRaw('SUM(order_items.product_price * order_items.quantity) >= ?', [$minPrice]);
        }
        if (is_numeric($maxPrice)) {
            $query->havingRaw('SUM(order_items.product_price * order_items.quantity) <= ?', [$maxPrice]);
        }

        // Sorting
        if (in_array($sortBy, $allowedSorts, true)) {
            $query->orderBy(DB::raw($sortBy), $sortDir);
        } else {
            $query->orderBy($sortBy, $sortDir);
        }

        $startDate = $request->query('start_date'); // e.g., 2025-01-01
        $endDate = $request->query('end_date');     // e.g., 2025-12-31

        if ($startDate) {
            $query->whereDate('order_items.created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('order_items.created_at', '<=', $endDate);
        }

        $order_items = $query->paginate($perPage)->appends($request->query());

        $productIds = $order_items->pluck('product_id')->unique();

        $products = Product::with('media')
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $count = OrderItem::count();

        // For filters dropdowns
        $categories = Category::orderBy('order')->get(['id', 'name']);
        $subcategories = Subcategory::orderBy('order')->get(['id', 'name', 'category_id']);

        return view('backend.admin_sold_products_sum', compact('order_items', 'sortBy', 'sortDir', 'count', 'categories', 'subcategories', 'products'));
    }

    public function allCategories(Request $request)
    {

        $data = (new AdminService)->allCategories($request);
        $categories = $data['categories'];
        $sortBy = $data['sortBy'];
        $sortDir = $data['sortDir'];

        $subcategories = Subcategory::orderBy('order')->get(['id', 'name', 'category_id']);
        $discounts = Discount::where('active', 1)->get();
        $count = Category::count();
        $settings = Setting::first();
        $coupons = Coupon::where('active', 1)->with('promoter')->get();

        return view('backend.admin_categories', compact('categories', 'settings', 'count', 'subcategories', 'sortBy', 'sortDir', 'discounts', 'coupons'));
    }

    public function allAdmins(Request $request)
    {

        $admins = Admin::orderBy('id', 'desc')->with('roles.permissions')->get();
        $permissions = Permission::all();
        $roles = Role::all();

        return view('backend.admin_admins', compact('admins', 'permissions', 'roles'));
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8',
            'mobile' => 'required',
        ]);

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => bcrypt($request->password),
        ]);

        $admin->assignRole('admin');

        return back()->with('success', 'User created successfully');

    }

    public function updateAdmin(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:admins,id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|string|min:8',
            'mobile' => 'required',
        ]);

        $admin = Admin::find($request->id);
        $admin->name = $request->name;
        if ($admin->email != $request->email) {
            $request->validate([
                'email' => 'required|string|email|max:255|unique:admins',
            ]);
            $admin->email = $request->email;
        }
        $admin->mobile = $request->mobile;
        if ($request->password) {
            $admin->password = bcrypt($request->password);
        }
        $admin->save();

        return back()->with('success', 'User created successfully');

    }

    public function allUsers(Request $request)
    {

        $users = User::orderBy('id', 'desc')
            ->with('orders')
            ->with('orders.city')
            ->withCount('orders')
            ->paginate(10);

        return view('backend.admin_users', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8',
            'mobile' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole('admin');

        return back()->with('success', 'User created successfully');

    }

    public function updateUser(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|string|min:8',
            'mobile' => 'required',
            'pid' => [
                'nullable',
                'regex:/^(\d{9}|\d{11})$/',
            ],
        ]);

        $user = User::find($request->id);
        $user->name = $request->name;
        if ($user->email != $request->email) {
            $request->validate([
                'email' => 'required|string|email|max:255|unique:admins',
            ]);
            $user->email = $request->email;
        }
        $user->mobile = $request->mobile;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->pid = $request->pid;
        $user->save();

        return back()->with('success', 'User created successfully');
    }

    public function autoLogin(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();

        Auth::guard('web')->login($user);

        Session::put('auth', $user);

        return to_route('home');
    }

    public function orderItemsHtmx(Request $request)
    {

        $order_items = OrderItem::where('order_id', $request->order_id)
            ->with('product', 'order')->get();

        return view('backend.components.modals.htmx.order_items_htmx', compact('order_items'));
    }

    public function export()
    {
        //        return Excel::download(new TotalSalesExport(), 'users.xlsx');
    }
}
