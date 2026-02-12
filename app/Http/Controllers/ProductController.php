<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductOrder;
use App\Services\CartService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductController extends BaseController
{
    protected $cart;

    public function __construct(CartService $cart)
    {
        parent::__construct();

        $this->cart = $cart;

    }

    public function store(Request $request)
    {

        new ProductService()->store($request, $this->mainLocale, $this->locales);

        return back()->with('alert_success', 'Product created successfully.');
    }

    public function delete(Request $request)
    {
        $product = Product::find($request->product_id);

        if (! $product) {
            return back()->with('alert_error', __('Product not found'));
        }

        if ($product->orderItems()->exists()) {
            return back()->with('alert_error', __('Cannot delete product that has order items.'));
        }

        $product->clearMediaCollection('product_image');
        $product->clearMediaCollection('thumbnail');
        $product->delete();

        return back()->with('alert_success', __('Product deleted successfully.'));
    }

    public function show($locale, $slug)
    {
        $query = Product::where('slug', $slug)
            ->with([
                'features' => function ($query) {
                    $query->orderBy('id'); // order by id ascending
                },
                'media', // keep media as usual
            ])->first();

        if (! $query && is_numeric($slug)) {
            $query = Product::where('id', $slug)
                ->with([
                    'features' => function ($query) {
                        $query->orderBy('id'); // order by id ascending
                    },
                    'media', // keep media as usual
                ])->first();
        }

        $product = $query;

        if (! $product) {
            return redirect()->route('home') // Redirect to a specific route
                ->with('alert_error', __('Product not found'));
        }

        if ($product->removed_from_store) {
            return redirect()->route('home')
                ->with('alert_error', __('Product is not available'));
        }

        $settings = $this->site_settings;

        $main_image = Media::where('model_id', $product->id)
            ->where('collection_name', 'product_image')
            ->where('main', 1)
            ->first();

        $similar_products = Product::where('category_id', $product->category_id)
            ->inRandomOrder()
            ->take(10)
            ->get();
        //        dd($similar_products);

        $cartItems = $this->cart->getCart();

        if ($cartItems->contains('product_id', $product->id)) {
            $in_cart = true;
        } else {
            $in_cart = false;
        }

        return view('frontend.product-single.product_single', compact('in_cart', 'product', 'settings', 'main_image', 'similar_products'));
    }

    public function mainImage(Request $request)
    {
        $productmedia = Media::where('model_id', $request->input('model_id'))->get();

        foreach ($productmedia as $media) {
            $media->main = 0;
            $media->save();
        }

        $media = Media::find($request->input('media_id'));

        if ($media) {
            if ($media->main == 1) {
                $media->main = 0;
            } else {
                $media->main = 1;
            }
            $media->save();

            return back()->with('alert_success', __('Product image updated successfully.'));

        }

        return back()->with('alert_error', __('Product not found.'));

    }

    public function deleteImage(Request $request)
    {

        $media = Media::find($request->input('media_id'));

        if ($media) {
            $media->delete();

            //            return back()->with('alert_success', 'Image deleted successfully');
            $success = __('Images deleted successfully');
            //            return back()->with('alert_success', 'Images added successfully');
            //            return view('backend.htmx.messages_htmx', compact('success'));

            return response()
                ->view('backend.htmx.messages_htmx')
                ->header('HX-Trigger', json_encode([
                    'showSuccess' => [
                        'icon' => 'success',
                        'message' => __('Image deleted successfully'),
                    ],
                ]));
        }

        //        return back()->with('alert_error', 'Media not found');

        return response()
            ->view('backend.htmx.messages_htmx')
            ->header('HX-Trigger', json_encode([
                'showError' => [
                    'icon' => 'error',
                    'message' => __('Media not found'),
                ],
            ]));
    }

    public function addImage(Request $request)
    {
        return new ProductService()->addImage($request);
        //        return back()->with('alert_error', 'Product not found');
    }

    public function priceUpdate(Request $request)
    {

        new ProductService()->priceUpdate($request);

        return back()->with('alert_success', 'Price updated successfully');
    }

    public function stockUpdate(Request $request)
    {

        new ProductService()->stockUpdate($request);

        return back()->with('alert_success', 'Stock updated successfully');
    }

    public function inStock(Request $request)
    {

        return new ProductService()->inStock($request);

    }

    public function removed(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->input('product_id'));

        // Toggle removed_from_store. When enabling removal, also ensure out of stock.
        if (! $product->removed_from_store) {
            $product->removed_from_store = true;
            $product->in_stock = 0;
        } else {
            $product->removed_from_store = false;
        }

        $product->save();

        return back()->with('alert_success', $product->removed_from_store
            ? __('Product removed from store and hidden from customers.')
            : __('Product restored to store.'));
    }

    public function descriptionUpdate(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'description_'.$this->mainLocale->abbr => 'required|string',
        ]);
        $product = Product::findOrFail($request->input('product_id'));
        foreach ($this->locales as $locale) {
            $cleaned_descr = preg_replace('/\s+/', ' ', $request->input('description_'.$locale->abbr));
            $trimmed_descr = trim($cleaned_descr);
            $product->setTranslation('description', $locale->abbr, $trimmed_descr);
        }

        $product->save();

        return back()->with('alert_success', 'Description updated successfully');
    }

    public function nameUpdate(Request $request)
    {

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_name_'.$this->mainLocale->abbr => 'required|string|max:255',
        ]);
        $product = Product::findOrFail($request->input('product_id'));
        foreach ($this->locales as $locale) {
            $cleaned_descr = preg_replace('/\s+/', ' ', $request->input('product_name_'.$locale->abbr));
            $trimmed_descr = trim($cleaned_descr);
            $product->setTranslation('name', $locale->abbr, $trimmed_descr);
        }

        $product->save();

        return to_route('product.single', [app()->getLocale(), $product->slug])
            ->with('alert_success', 'Name updated successfully');
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->input('product_id'));
        $product->order = $request->input('order');
        $product->save();

        return back()->with('alert_success', 'Order updated successfully');
    }

    public function updateMain(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->input('product_id'));

        // Build query for products in the same category/subcategory
        $query = Product::query();

        if ($product->subcategory_id) {
            $query->where('subcategory_id', $product->subcategory_id);
        } else {
            $query->where('category_id', $product->category_id);
        }

        $mainCount = $query->where('show_in_main', 1)->count();

        // ✅ Only check when turning ON
        if ($product->show_in_main == 0) {
            if ($mainCount >= 6) {
                return back()->with('alert_error', 'You can only have 6 products in main for this '.
                    ($product->subcategory_id ? 'subcategory' : 'category').'.');
            }
            $product->show_in_main = 1;
        } else {
            $product->show_in_main = 0;
        }

        $product->save();

        return back()->with('alert_success', 'Product updated successfully');
    }

    public function updateVideo(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'video' => 'required|string|max:100',
        ]);

        $url = $request->input('video');
        $host = parse_url($url, PHP_URL_HOST);

        if (! in_array($host, ['www.youtube.com', 'youtube.com', 'youtu.be'])) {
            return back()->withErrors(['video' => 'The video must be a valid YouTube link.']);
        }

        // Parse query string from URL
        parse_str(parse_url($url, PHP_URL_QUERY), $query);

        // Get the video ID
        $videoId = $query['v'] ?? null;
        //        dd($videoId);
        $product = Product::find($request->input('product_id'));
        $product->embed_video = $videoId;
        $product->save();

        return back()->with('alert_success', 'Video updated successfully');
    }

    public function deleteVideo(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::find($request->input('product_id'));
        $product->embed_video = null;
        $product->save();

        return back()->with('alert_success', 'Video deleted successfully');
    }

    public function featured(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::find($request->input('product_id'));
        if ($product->featured == 1) {
            $product->featured = 0;
        } else {
            $product->featured = 1;
        }
        $product->save();

        return response()
            ->view('backend.htmx.messages_htmx')
            ->header('HX-Trigger', json_encode([
                'showSuccess' => [
                    'icon' => 'success',
                    'message' => __('Updated successfully'),
                ],
            ]));
    }

    public function onMain(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::find($request->input('product_id'));
        if ($product->show_in_main == 1) {
            $product->show_in_main = 0;
        } else {
            $product->show_in_main = 1;
        }
        $product->save();

        return response()
            ->view('backend.htmx.messages_htmx')
            ->header('HX-Trigger', json_encode([
                'showSuccess' => [
                    'icon' => 'success',
                    'message' => __('Updated successfully'),
                ],
            ]));
    }

    public function toggleForSale(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::find($request->input('product_id'));
        if ($product->for_sale == 1) {
            $product->for_sale = 0;
            $messsage = __('Not for Sale set successfully');
        } else {
            $product->for_sale = 1;
            $messsage = __('Marked as For Sale');
        }
        $product->save();

        return response()
            ->view('backend.htmx.not_for_sale', compact('product'))
            ->header('HX-Trigger', json_encode([
                'showSuccess' => [
                    'icon' => 'success',
                    'message' => $messsage,
                ],
            ]));
    }

    public function htmxImages(Request $request)
    {

        $product = Product::where('id', $request->product_id)->with('media')->first();
        if ($product) {
            return view('backend.components.images_htmx', compact('product'));
        } else {
            return 'Product not found';
        }
    }

    public function searchHtmx(Request $request)
    {

        $search = trim($request->input('search', ''));

        $search_products = [];

        if (mb_strlen($search, 'UTF-8') >= 3) {
            $search_products = Product::whereLike('name', "%{$search}%")
                ->where('removed_from_store', false)
                ->with('media')
                ->paginate(10);
        }

        return view('frontend.components.toasts.search_htmx', compact('search_products'));
    }

    public function discounted(Request $request)
    {

        $query = Product::where('discounted', 1)->with('media');

        // Extract optional filters from query string
        $minPrice = $request->query('min_price');
        $maxPrice = $request->query('max_price');
        $sortDir = strtolower($request->query('sort', 'asc')) === 'desc' ? 'desc' : 'asc';

        // Normalize numeric inputs if provided
        $minPrice = is_numeric($minPrice) ? (float) $minPrice : null;
        $maxPrice = is_numeric($maxPrice) ? (float) $maxPrice : null;
        if (! is_null($minPrice) && $minPrice < 0) {
            $minPrice = 0;
        }
        if (! is_null($maxPrice) && $maxPrice < 0) {
            $maxPrice = 0;
        }
        if (! is_null($minPrice) && ! is_null($maxPrice) && $minPrice > $maxPrice) {
            [$minPrice, $maxPrice] = [$maxPrice, $minPrice];
        }

        if (! is_null($minPrice)) {
            $query->where('price', '>=', $minPrice);
        }
        if (! is_null($maxPrice)) {
            $query->where('price', '<=', $maxPrice);
        }
        if ($request->has('sort')) {
            // Override default relationship ordering when sorting by price
            $query->reorder('price', $sortDir);
        }

        $products = $query->paginate(10)->appends($request->query());

        $site_settings = $this->site_settings;
        $banners = $this->banners;

        return view('frontend.discounted_products.discounted_products', compact('banners', 'site_settings', 'products'));

    }

    public function forMain(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::find($request->input('product_id'));
        $product_order = ProductOrder::where('product_id', $product->id)->first();
        if ($product_order) {
            $product->show_in_main_single = false;
            $product_order->delete();
        } else {
            $newproductorder = new ProductOrder;
            $newproductorder->product_id = $product->id;
            $newproductorder->save();
            $product->show_in_main_single = true;
        }
        $product->save();

        return response()
            ->view('backend.htmx.messages_htmx')
            ->header('HX-Trigger', json_encode([
                'showSuccess' => [
                    'icon' => 'success',
                    'message' => __('Updated successfully'),
                ],
            ]));
    }
}
