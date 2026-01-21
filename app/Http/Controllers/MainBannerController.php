<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\MainBanner;
use App\Models\Setting;
use App\Services\CartService;
use App\Services\Conversion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MainBannerController extends Controller
{
    protected $locales;

    protected $mainLocale;

    protected $settings;

    public function __construct(CartService $cart)
    {
        // Initialize the variable once for all methods
        $this->locales = Language::all();
        $this->mainLocale = Language::where('main', 1)->first();
        $this->settings = Setting::first();
    }

    public function index(Request $request)
    {

        $banners = MainBanner::all();

        return view('backend.admin_banners', compact('banners'));
    }

    public function create(Request $request)
    {

        $request->validate([
            'header' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'image' => 'required|mimes:jpeg,jpg,png,gif,webp|max:5024',
        ]);

        $banner = new MainBanner;

        foreach ($this->locales as $locale) {
            $cleaned = preg_replace('/\s+/', ' ', $request->input('header_'.$locale->abbr));
            $trimmed = trim($cleaned);
            $cleaned_descr = preg_replace('/\s+/', ' ', $request->input('description_'.$locale->abbr));
            $trimmed_descr = trim($cleaned_descr);
            $banner->setTranslation('header', $locale->abbr, $trimmed);
            $banner->setTranslation('description', $locale->abbr, $trimmed_descr);
        }

        $banner->save();

        $uploadedFile = $request->file('image');

        $mainImage = new Conversion()->convert($uploadedFile);

        Storage::disk('public')->put($banner->header.'.webp', $mainImage);
        $banner->addMedia(storage_path('app/public/'.$banner->header.'.webp'))->toMediaCollection('banner_image');
        Storage::disk('public')->delete($banner->header.'.webp');

        return back();

    }

    public function update(Request $request)
    {
        $request->validate([
            'banner_id' => 'required|exists:main_banners,id',
            'header' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif,webp|max:5024',
        ]);

        $banner = MainBanner::find($request->input('banner_id'));

        foreach ($this->locales as $locale) {
            $cleaned = preg_replace('/\s+/', ' ', $request->input('header_'.$locale->abbr));
            $trimmed = trim($cleaned);
            $cleaned_descr = preg_replace('/\s+/', ' ', $request->input('description_'.$locale->abbr));
            $trimmed_descr = trim($cleaned_descr);
            $banner->setTranslation('header', $locale->abbr, $trimmed);
            $banner->setTranslation('description', $locale->abbr, $trimmed_descr);
        }

        $banner->save();

        if ($request->hasFile('image')) {

            $media = $banner->media()->first();
            if ($media) {
                $media->delete();
            }

            $uploadedFile = $request->file('image');

            $mainImage = new Conversion()->convert($uploadedFile);

            Storage::disk('public')->put($banner->header.'.webp', $mainImage);
            $banner->addMedia(storage_path('app/public/'.$banner->header.'.webp'))->toMediaCollection('banner_image');
            Storage::disk('public')->delete($banner->header.'.webp');
        }

        return back();

    }

    public function delete(Request $request)
    {

        $request->validate([
            'banner_id' => 'required|exists:main_banners,id',
        ]);

        $banner = MainBanner::find($request->input('banner_id'));
        $media = $banner->media()->first();

        if ($media) {
            $media->delete();
        }

        $banner->delete();

        return back();

    }

    public function activate(Request $request)
    {
        $request->validate([
            'banner_id' => 'required|exists:main_banners,id',
        ]);

        $banner = MainBanner::find($request->input('banner_id'));

        if ($banner->is_active == 1) {
            $banner->is_active = 0;
        } else {
            $banner->is_active = 1;
        }
        $banner->save();

        return back();
    }
}
